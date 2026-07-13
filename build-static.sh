#!/usr/bin/env bash
# ------------------------------------------------------------------
# Build a static, Netlify-ready export of the Real del Mar site into ../dist
# Usage:  ./build-static.sh
# Then drag the ../dist folder onto Netlify (or `netlify deploy --prod --dir ../dist`).
# ------------------------------------------------------------------
set -euo pipefail
cd "$(dirname "$0")"                     # app/
OUT="${OUT:-../dist}"
PORT=8099
# Public URL of the deployed site — used for canonical/og:url/og:image,
# which social scrapers require to be absolute. Override: SITE_URL=... ./build-static.sh
SITE_URL="${SITE_URL:-https://vento-tijuana.netlify.app}"

echo "▸ Building front-end assets…"
npm run build >/dev/null

echo "▸ Rendering the homepage…"
APP_URL="$SITE_URL" php artisan serve --port="$PORT" >/tmp/rdm-build-serve.log 2>&1 &
SERVER_PID=$!
trap 'kill "$SERVER_PID" 2>/dev/null || true' EXIT
# wait for the server to answer
for i in $(seq 1 20); do
  curl -s -o /dev/null "http://127.0.0.1:$PORT" && break || sleep 0.5
done

rm -rf "$OUT"; mkdir -p "$OUT"
HTTP_STATUS=$(curl -s -o "$OUT/index.html" -w "%{http_code}" "http://127.0.0.1:$PORT")
if [ "$HTTP_STATUS" != "200" ]; then
  echo "✗ Homepage rendered HTTP $HTTP_STATUS — aborting so we never publish an error page." >&2
  head -c 2000 "$OUT/index.html" >&2 || true
  exit 1
fi
kill "$SERVER_PID" 2>/dev/null || true

echo "▸ Making asset URLs root-relative…"
perl -pi -e "s#http://127\\.0\\.0\\.1:$PORT/#/#g; s#http://localhost:$PORT/#/#g; s#http://localhost/#/#g" "$OUT/index.html"
perl -pi -e "s{http:(?:\\\\*/){2}127\\.0\\.0\\.1:$PORT}{}g; s{http:(?:\\\\*/){2}localhost(?::$PORT)?}{}g" "$OUT/index.html"

echo "▸ Copying static assets…"
for d in site-assets images fonts; do cp -R "public/$d" "$OUT/$d"; done
[ -d public/videos ] && cp -R public/videos "$OUT/videos"
cp public/favicon.ico public/robots.txt public/gracias.html public/sitemap.xml \
   public/apple-touch-icon.png public/icon-512.png "$OUT/" 2>/dev/null || true

echo "▸ Writing cache headers (no netlify.toml/_redirects — keeps drag-drop clean)…"
cat > "$OUT/_headers" <<'HD'
/build/assets/*
  Cache-Control: public, max-age=31536000, immutable
/fonts/*
  Cache-Control: public, max-age=31536000, immutable
/images/*
  Cache-Control: public, max-age=2592000
/videos/*
  Cache-Control: public, max-age=2592000
HD

LEFT=$(grep -c '127.0.0.1\|localhost' "$OUT/index.html" || true)
echo "✓ Done. Output: $(cd "$OUT" && pwd)  ($(du -sh "$OUT" | cut -f1))  | leftover host refs: $LEFT"
