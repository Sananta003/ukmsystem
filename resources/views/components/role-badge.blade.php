@props(['role'])

@php
    $gradient = 'from-blue-400 to-sky-300';
    $text = 'text-white';
    $shadow = 'shadow-blue-400/40';
    $icon = 'fa-user';
    $label = 'Member';

    if ($role === 'super_admin' || $role === 'superadmin') {
        $gradient = 'from-violet-700 to-indigo-600';
        $shadow = 'shadow-violet-600/40';
        $icon = 'fa-crown';
        $label = 'Super Admin';
    } elseif ($role === 'bpm') {
        $gradient = 'from-orange-600 to-amber-500';
        $shadow = 'shadow-orange-500/40';
        $icon = 'fa-magnifying-glass-chart';
        $label = 'BPM';
    } elseif ($role === 'bem') {
        $gradient = 'from-emerald-600 to-teal-500';
        $shadow = 'shadow-emerald-500/40';
        $icon = 'fa-check-double';
        $label = 'BEM';
    } elseif ($role === 'admin_ukm') {
        $gradient = 'from-blue-700 to-blue-500';
        $shadow = 'shadow-blue-600/40';
        $icon = 'fa-user-tie';
        $label = 'Admin UKM';
    } elseif ($role === 'inisiator') {
        $gradient = 'from-blue-400 to-sky-300';
        $shadow = 'shadow-blue-400/40';
        $icon = 'fa-lightbulb';
        $label = 'Inisiator';
    }
@endphp

<div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-white bg-gradient-to-r {{ $gradient }} shadow-lg {{ $shadow }} transition-all duration-300 hover:-translate-y-1 hover:brightness-110 cursor-default border border-white/20">
    <i class="fa-solid {{ $icon }}"></i>
    <span>{{ $slot->isEmpty() ? $label : $slot }}</span>
</div>
