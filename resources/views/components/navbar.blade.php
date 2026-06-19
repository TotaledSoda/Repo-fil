<style>
    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    .animate-gradient {
        background-size: 200% 200%;
        animation: gradientShift 3s ease infinite;
    }
</style>
<header class="w-full top-0 sticky z-50 bg-background/80 backdrop-blur-md border-b border-white/5">
    <nav class="flex justify-between items-center h-16 sm:h-20 px-4 sm:px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
        <div class="flex items-center gap-2">
            
            <span class="font-headline-sm sm:font-headline-md text-headline-sm sm:text-headline-md font-bold tracking-tighter text-on-surface bg-gradient-to-r from-[#0F62FE] via-white to-[#0043CE] bg-clip-text text-transparent animate-gradient">
                Bitify Mx
            </span>
        </div>
        <div class="hidden md:flex gap-3 lg:gap-6 items-center">
            <a class="font-label-xs sm:font-label-sm text-label-xs sm:text-label-sm text-secondary font-bold cursor-pointer hover:text-white transition-colors" href="#">Servicios</a>
            <a class="font-label-xs sm:font-label-sm text-label-xs sm:text-label-sm text-on-surface-variant hover:text-on-surface transition-colors cursor-pointer" href="#">Casos de Estudio</a>
            <a class="font-label-xs sm:font-label-sm text-label-xs sm:text-label-sm text-on-surface-variant hover:text-on-surface transition-colors cursor-pointer" href="#">Soluciones</a>
            <a class="font-label-xs sm:font-label-sm text-label-xs sm:text-label-sm text-on-surface-variant hover:text-on-surface transition-colors cursor-pointer" href="#">Nosotros</a>
            <a class="font-label-xs sm:font-label-sm text-label-xs sm:text-label-sm text-on-surface-variant hover:text-on-surface transition-colors cursor-pointer" href="#">Contacto</a>
        </div>
        <button class="bg-gradient-to-r from-[#0F62FE] to-[#0043CE] text-white px-4 sm:px-5 py-2 sm:py-2.5 font-label-xs sm:font-label-sm text-label-xs sm:text-label-sm ml-2 sm:ml-4 uppercase tracking-widest rounded-lg hover:shadow-lg hover:shadow-[#0F62FE]/50 hover:from-[#1973FF] hover:to-[#0052D9] transition-all duration-300 cursor-pointer active:opacity-90 font-semibold">
            Obtener Cotización
        </button>
    </nav>
</header>