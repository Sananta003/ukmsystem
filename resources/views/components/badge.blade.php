@props(['role' => 'member', 'icon' => null])

@php
    $bg = 'bg-sky-100';
    $text = 'text-sky-700';
    $border = 'border-sky-200';
    $defaultIcon = 'fa-user';

    switch (strtolower($role)) {
        case 'super_admin':
        case 'superadmin':
            $bg = 'bg-slate-100';
            $text = 'text-slate-700';
            $border = 'border-slate-200';
            $defaultIcon = 'fa-shield-halved';
            break;
        case 'bpm':
            $bg = 'bg-amber-100';
            $text = 'text-amber-700';
            $border = 'border-amber-200';
            $defaultIcon = 'fa-clipboard-check';
            break;
        case 'bem':
            $bg = 'bg-emerald-100';
            $text = 'text-emerald-700';
            $border = 'border-emerald-200';
            $defaultIcon = 'fa-check-double';
            break;
        case 'admin_ukm':
            $bg = 'bg-blue-100';
            $text = 'text-blue-700';
            $border = 'border-blue-200';
            $defaultIcon = 'fa-user-tie';
            break;
        case 'member':
        case 'inisiator':
            $bg = 'bg-sky-100';
            $text = 'text-sky-700';
            $border = 'border-sky-200';
            $defaultIcon = 'fa-user';
            break;
    }
    
    $finalIcon = $icon ?? $defaultIcon;
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold {{ $bg }} {{ $text }} border {{ $border }}">
    @if($finalIcon)
        <i class="fa-solid {{ $finalIcon }}"></i>
    @endif
    {{ $slot }}
</span>
