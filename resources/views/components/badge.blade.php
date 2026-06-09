@props(['role' => 'member', 'icon' => null])

@php
    $bg = 'bg-gray-100';
    $text = 'text-gray-600';
    $border = 'border-gray-200';
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
            $bg = 'bg-orange-50';
            $text = 'text-orange-700';
            $border = 'border-orange-200';
            $defaultIcon = 'fa-clipboard-check';
            break;
        case 'bem':
            $bg = 'bg-green-50';
            $text = 'text-green-700';
            $border = 'border-green-200';
            $defaultIcon = 'fa-check-double';
            break;
        case 'admin_ukm':
            $bg = 'bg-blue-50';
            $text = 'text-blue-700';
            $border = 'border-blue-200';
            $defaultIcon = 'fa-user-tie';
            break;
        case 'member':
        case 'inisiator':
            $bg = 'bg-gray-100';
            $text = 'text-gray-600';
            $border = 'border-gray-200';
            $defaultIcon = 'fa-user';
            break;
    }
    
    $finalIcon = $icon ?? $defaultIcon;
@endphp

<span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-medium tracking-wide {{ $bg }} {{ $text }} border {{ $border }}">
    @if($finalIcon)
        <i class="fa-solid {{ $finalIcon }}"></i>
    @endif
    {{ $slot }}
</span>
