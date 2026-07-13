{{-- ============================== CONTACTO ============================== --}}
<section id="contacto" class="bg-beige py-24 lg:py-32">
    <div class="mx-auto max-w-xl px-6 lg:px-10">
        <div class="reveal-group text-center">
            <p class="eyebrow text-wood-500">Contacto</p>
            <h2 class="display mt-5 text-4xl font-light text-ink sm:text-5xl">Agenda una asesoría <span class="accent-italic">personalizada</span></h2>
            <p class="mx-auto mt-5 max-w-lg text-lg leading-relaxed text-ink-soft">Déjanos tus datos y un asesor de City Inmobiliaria te contactará con información sobre disponibilidad, precios, tipologías y recorridos.</p>
        </div>

        <form name="asesoria" method="POST" data-netlify="true" netlify-honeypot="bot-field" action="/gracias.html"
            class="reveal mt-12 space-y-4 rounded-3xl bg-white p-8 shadow-xl shadow-ink/10 ring-1 ring-ink/5 lg:p-10">
            <input type="hidden" name="form-name" value="asesoria">
            <p class="hidden" aria-hidden="true"><label>Campo interno: <input name="bot-field" tabindex="-1" autocomplete="off"></label></p>

            <input type="text" name="nombre" placeholder="Nombre completo" required autocomplete="name"
                class="w-full rounded-xl border-ink/10 bg-sand-50 px-4 py-3.5 text-sm focus:border-wood-400 focus:ring-wood-400">
            <input type="tel" name="telefono" placeholder="Teléfono o WhatsApp" required autocomplete="tel" inputmode="tel"
                class="w-full rounded-xl border-ink/10 bg-sand-50 px-4 py-3.5 text-sm focus:border-wood-400 focus:ring-wood-400">
            <input type="email" name="email" placeholder="Correo electrónico" required autocomplete="email"
                class="w-full rounded-xl border-ink/10 bg-sand-50 px-4 py-3.5 text-sm focus:border-wood-400 focus:ring-wood-400">
            <select name="interes" id="interes" required
                class="w-full rounded-xl border-ink/10 bg-sand-50 px-4 py-3.5 text-sm text-ink focus:border-wood-400 focus:ring-wood-400">
                <option value="" disabled selected>¿Qué te interesa?</option>
                <option>Recibir información</option>
                <option>Consultar disponibilidad</option>
                <option>Ver tipologías</option>
                <option>Agendar recorrido</option>
                <option>Información para brokers</option>
            </select>
            <textarea name="mensaje" placeholder="Mensaje (opcional)" rows="3"
                class="w-full rounded-xl border-ink/10 bg-sand-50 px-4 py-3.5 text-sm focus:border-wood-400 focus:ring-wood-400"></textarea>

            <label class="flex items-start gap-3 pt-1 text-left text-[0.7rem] leading-relaxed text-ink-soft/80">
                <input type="checkbox" name="acepto-contacto" required
                    class="mt-0.5 h-4 w-4 shrink-0 rounded border-ink/20 text-wood-500 focus:ring-wood-400">
                {{-- TODO: enlazar el Aviso de Privacidad cuando el cliente entregue el documento --}}
                <span>Acepto ser contactado por City Inmobiliaria vía llamada, mensaje o correo electrónico y confirmo haber leído el Aviso de Privacidad.</span>
            </label>

            <div class="pt-2">
                <button type="submit" id="cta-enviar"
                    class="eyebrow w-full rounded-full bg-wood-500 px-8 py-4 text-[0.7rem] text-sand-50 transition-colors hover:bg-wood-400">Enviar solicitud</button>
            </div>
            {{-- TODO: botones de WhatsApp y llamada — pendientes el número comercial de City Inmobiliaria --}}
            <p class="pt-2 text-center text-[0.7rem] leading-relaxed text-ink-soft/70">Tu información será tratada con privacidad y utilizada únicamente para darte seguimiento.</p>
        </form>
    </div>
</section>
