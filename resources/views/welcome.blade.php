<x-layout>

{{-- ═══════════════════════════════════════════
     HERO CARRUSEL
═══════════════════════════════════════════ --}}
<section
    class="relative pt-20 pb-24 md:pt-32 md:pb-36 px-6 md:px-12 max-w-container-max mx-auto"
    x-data="{ activeSlide: 1, total: {{ $heroSlides->count() }}, go(n) { this.activeSlide = ((n - 1 + this.total) % this.total) + 1 } }">

    @foreach($heroSlides as $index => $slide)
    <div
        x-show="activeSlide === {{ $index + 1 }}"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-x-6"
        x-transition:enter-end="opacity-100 translate-x-0"
        class="grid gap-16 items-center lg:grid-cols-[1fr_1fr]">

        {{-- TEXTO --}}
        <div class="flex flex-col gap-7">

            {{-- Eyebrow con línea --}}
            <div class="flex items-center gap-3">
                <span class="w-8 h-px bg-[#0F62FE]"></span>
                @if($slide->tag)
                <span class="text-[11px] font-semibold tracking-[0.22em] uppercase text-[#0F62FE]">
                    {{ $slide->tag }}
                </span>
                @endif
                <span class="ml-auto text-[11px] font-mono text-white/20 tracking-widest">
                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}&thinsp;/&thinsp;{{ str_pad($heroSlides->count(), 2, '0', STR_PAD_LEFT) }}
                </span>
            </div>

            {{-- Título --}}
            <h1 class="font-['Montserrat'] text-4xl md:text-5xl xl:text-6xl font-extrabold leading-[1.06] tracking-[-0.03em]"
                style="background: linear-gradient(135deg, #e2e8f0 0%, #94a3b8 50%, #22d3ee 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                {!! nl2br(e($slide->title)) !!}
            </h1>

            {{-- Descripción --}}
            <p class="text-[15px] leading-[1.8] text-slate-400 max-w-lg">
                {{ $slide->description }}
            </p>

            {{-- CTA --}}
            @if($slide->cta_url)
            <div class="flex items-center gap-4 pt-1">
                <a href="{{ $slide->cta_url }}"
                    class="group inline-flex items-center gap-2.5 bg-[#0F62FE] px-6 py-3 text-[13px] font-semibold text-white tracking-wide rounded-sm hover:bg-[#0353e9] transition-colors duration-200">
                    {{ $slide->cta_label ?? 'Ver más' }}
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <span class="w-px h-5 bg-white/10"></span>
                <a href="#servicios" class="text-[13px] text-white/40 hover:text-white/70 transition-colors tracking-wide">
                    Ver servicios
                </a>
            </div>
            @endif
        </div>

        {{-- IMAGEN --}}
        <div class="relative">
            {{-- Marco decorativo top-left --}}
            <div class="absolute -top-4 -left-4 w-24 h-24 pointer-events-none z-0"
                 style="border-top: 1px solid rgba(15,98,254,0.4); border-left: 1px solid rgba(15,98,254,0.4);"></div>
            {{-- Marco decorativo bottom-right --}}
            <div class="absolute -bottom-4 -right-4 w-24 h-24 pointer-events-none z-0"
                 style="border-bottom: 1px solid rgba(6,182,212,0.3); border-right: 1px solid rgba(6,182,212,0.3);"></div>

            {{-- Imagen --}}
            <div class="relative z-10 rounded-sm overflow-hidden"
                 style="border: 1px solid rgba(255,255,255,0.07);">
                <img src="{{ asset('storage/' . $slide->image_path) }}"
                     alt="{{ $slide->title }}"
                     class="w-full h-[340px] md:h-[480px] object-cover block" />

                {{-- Overlay sutil --}}
                <div class="absolute inset-0 pointer-events-none"
                     style="background: linear-gradient(to top, rgba(5,10,20,0.5) 0%, transparent 50%);"></div>

                {{-- Chip flotante bottom-left --}}
                <div class="absolute bottom-4 left-4 flex items-center gap-2 px-3 py-1.5 rounded-sm"
                     style="background: rgba(5,10,20,0.75); border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(8px);">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#06b6d4] animate-pulse"></span>
                    <span class="text-[11px] font-mono text-white/60 tracking-widest uppercase">En línea</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- NAVEGACIÓN --}}
    <div class="flex items-center gap-6 mt-14">
        {{-- Indicadores --}}
        <div class="flex items-center gap-2">
            @foreach($heroSlides as $index => $slide)
            <button
                @click="go({{ $index + 1 }})"
                :class="activeSlide === {{ $index + 1 }}
                    ? 'w-8 bg-[#0F62FE]'
                    : 'w-3 bg-white/15 hover:bg-white/30'"
                class="h-[3px] rounded-full transition-all duration-400"
                aria-label="Slide {{ $index + 1 }}">
            </button>
            @endforeach
        </div>

        {{-- Botones --}}
        <div class="flex gap-2 ml-auto">
            <button @click="go(activeSlide - 1)" aria-label="Anterior"
                class="w-9 h-9 flex items-center justify-center rounded-sm text-white/40 hover:text-white hover:border-white/30 transition-all duration-150"
                style="border: 1px solid rgba(255,255,255,0.1);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="go(activeSlide + 1)" aria-label="Siguiente"
                class="w-9 h-9 flex items-center justify-center rounded-sm text-white/40 hover:text-white hover:border-white/30 transition-all duration-150"
                style="border: 1px solid rgba(255,255,255,0.1);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</section>

{{-- Divisor --}}
<div class="max-w-container-max mx-auto px-6 md:px-12">
    <div style="height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.06) 30%, rgba(255,255,255,0.06) 70%, transparent);"></div>
</div>


{{-- ═══════════════════════════════════════════
     SERVICIOS
═══════════════════════════════════════════ --}}
<section id="servicios" class="py-20 md:py-28 px-6 md:px-12 max-w-container-max mx-auto">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-14">
        <div class="flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <span class="w-6 h-px bg-[#06b6d4]"></span>
                <span class="text-[11px] font-semibold tracking-[0.22em] uppercase text-[#06b6d4]">Qué hacemos</span>
            </div>
            <h2 class="font-['Montserrat'] text-3xl md:text-4xl font-extrabold tracking-[-0.025em] text-white">
                Servicios
            </h2>
        </div>
        <div class="flex items-center gap-2 self-start md:self-auto"
             style="border: 1px solid rgba(255,255,255,0.07); padding: 6px 14px; border-radius: 2px;">
            <span class="w-1.5 h-1.5 rounded-full bg-[#06b6d4]"></span>
            <span class="text-[11px] font-mono text-white/40 tracking-widest uppercase">
                {{ $servicios->count() }} soluciones
            </span>
        </div>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px"
         style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.05);">

        @foreach($servicios->sortBy('title') as $i => $servicio)
        <article class="group relative flex flex-col overflow-hidden"
                 style="background: #050A14;">

            {{-- Línea top que se ilumina al hover (FIRMA) --}}
            <div class="absolute top-0 left-0 right-0 h-px transition-all duration-500"
                 style="background: linear-gradient(to right, transparent, rgba(6,182,212,0) 20%, rgba(6,182,212,0) 80%, transparent);"
                 x-data
                 :style="'background: linear-gradient(to right, transparent, rgba(6,182,212,0.7) 20%, rgba(124,58,237,0.7) 80%, transparent); opacity: 0; transition: opacity 0.4s;'"
                 @mouseenter.closest("article"="this.style.opacity=1"
                 @mouseleave.closest="article"="this.style.opacity=0">
            </div>

            {{-- Imagen --}}
            <div class="h-44 overflow-hidden flex-shrink-0 relative">
                <img src="{{ asset('storage/' . $servicio->image_path) }}"
                     alt="{{ $servicio->title }}"
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <div class="absolute inset-0"
                     style="background: linear-gradient(to bottom, transparent 40%, #050A14 100%);"></div>

                {{-- Número índice --}}
                <span class="absolute top-3 right-3 text-[11px] font-mono text-white/20 tracking-widest">
                    {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                </span>
            </div>

            {{-- Contenido --}}
            <div class="flex flex-col flex-1 p-6 gap-4">

                {{-- Icono + título --}}
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 flex items-center justify-center flex-shrink-0 rounded-sm mt-0.5"
                         style="background: rgba(6,182,212,0.08); border: 1px solid rgba(6,182,212,0.15);">
                        <span class="material-symbols-outlined text-[#06b6d4]" style="font-size:17px;">{{ $servicio->icon }}</span>
                    </div>
                    <h3 class="text-[15px] font-semibold text-white leading-snug pt-1">
                        {{ $servicio->title }}
                    </h3>
                </div>

                {{-- Descripción --}}
                <p class="text-[13px] text-white/45 leading-relaxed flex-1">
                    {{ $servicio->description }}
                </p>

                {{-- Footer card --}}
                <div class="flex items-center justify-between pt-2"
                     style="border-top: 1px solid rgba(255,255,255,0.05);">
                    <span class="text-[11px] font-mono text-white/20 tracking-wide">+10 proyectos</span>
                    <a href="#" class="group/btn inline-flex items-center gap-1.5 text-[12px] font-semibold text-[#06b6d4] hover:text-white transition-colors duration-200 tracking-wide">
                        Ver detalle
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</section>

{{-- Divisor --}}
<div class="max-w-container-max mx-auto px-6 md:px-12">
    <div style="height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.06) 30%, rgba(255,255,255,0.06) 70%, transparent);"></div>
</div>


{{-- ═══════════════════════════════════════════
     ABOUT
═══════════════════════════════════════════ --}}
<section class="py-20 md:py-28 px-6 md:px-12 max-w-container-max mx-auto">
    <div class="grid md:grid-cols-2 gap-16 xl:gap-24 items-center">

        {{-- IMAGEN --}}
        <div class="relative">
            {{-- Marco angular top-left --}}
            <div class="absolute -top-5 -left-5 w-20 h-20 pointer-events-none z-0"
                 style="border-top: 1px solid rgba(15,98,254,0.5); border-left: 1px solid rgba(15,98,254,0.5);"></div>

            {{-- Imagen --}}
            <div class="relative z-10 overflow-hidden rounded-sm"
                 style="border: 1px solid rgba(255,255,255,0.06);">
                <img src="{{ asset('storage/' . $aboutSection->image_path) }}"
                     alt="{{ $aboutSection->title }}"
                     class="w-full object-cover grayscale hover:grayscale-0 transition-all duration-700 block" />

                {{-- Barra inferior azul --}}
                <div class="absolute bottom-0 left-0 right-0 h-px bg-[#0F62FE]"></div>
            </div>

            {{-- Marco angular bottom-right --}}
            <div class="absolute -bottom-5 -right-5 w-20 h-20 pointer-events-none z-0"
                 style="border-bottom: 1px solid rgba(15,98,254,0.3); border-right: 1px solid rgba(15,98,254,0.3);"></div>

            {{-- Badge flotante --}}
            <div class="absolute -bottom-3 left-6 z-20 flex items-center gap-2 px-4 py-2 rounded-sm"
                 style="background: #050A14; border: 1px solid rgba(15,98,254,0.25);">
                <span class="w-1.5 h-1.5 rounded-full bg-[#0F62FE] animate-pulse"></span>
                <span class="text-[11px] font-mono text-white/50 tracking-widest uppercase">Tech-Spectrum</span>
            </div>
        </div>

        {{-- CONTENIDO --}}
        <div class="flex flex-col gap-7">

            {{-- Eyebrow --}}
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-3">
                    <span class="w-6 h-px bg-[#0F62FE]"></span>
                    <span class="text-[11px] font-semibold tracking-[0.22em] uppercase text-[#0F62FE]">
                        {{ $aboutSection->eyebrow }}
                    </span>
                </div>
                <h2 class="font-['Montserrat'] text-3xl md:text-4xl font-extrabold tracking-[-0.025em] text-white leading-tight">
                    {{ $aboutSection->title }}
                </h2>
            </div>

            {{-- Descripción --}}
            <p class="text-[14px] md:text-[15px] text-white/50 leading-[1.85]">
                {{ $aboutSection->description }}
            </p>

            {{-- Features --}}
            <div class="flex flex-col gap-3 pt-1">
                @foreach(['feature_1', 'feature_2', 'feature_3'] as $fi => $feat)
                    @if($aboutSection->$feat)
                    <div class="flex items-start gap-4 group"
                         style="padding: 12px 14px; border: 1px solid rgba(255,255,255,0.05); border-radius: 2px;">
                        <div class="w-5 h-5 flex items-center justify-center flex-shrink-0 mt-0.5 rounded-sm"
                             style="background: rgba(15,98,254,0.1); border: 1px solid rgba(15,98,254,0.2);">
                            <svg class="w-3 h-3 text-[#0F62FE]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-[13px] text-white/60 leading-relaxed">
                            {{ $aboutSection->$feat }}
                        </span>
                    </div>
                    @endif
                @endforeach
            </div>

            {{-- CTA --}}
            @if($aboutSection->button_text)
            <div class="flex items-center gap-4 pt-2">
                <a href="{{ $aboutSection->button_url }}"
                   class="group inline-flex items-center gap-2.5 bg-[#0F62FE] px-6 py-3 text-[13px] font-semibold text-white tracking-wide rounded-sm hover:bg-[#0353e9] transition-colors duration-200">
                    {{ $aboutSection->button_text }}
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Hover glow en tarjetas de servicios --}}
<style>
    article:hover > div:first-child {
        opacity: 1 !important;
        background: linear-gradient(to right, transparent, rgba(6,182,212,0.7) 20%, rgba(124,58,237,0.7) 80%, transparent) !important;
    }
    article > div:first-child {
        opacity: 0;
        transition: opacity 0.4s ease;
    }
</style>

</x-layout>