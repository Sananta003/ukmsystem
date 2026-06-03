import os

# member.blade.php replacements
member_file = 'resources/views/layouts/member.blade.php'
with open(member_file, 'r', encoding='utf-8') as f:
    content = f.read()

php_block = """    @php
        $userUkm = Auth::user()->ukm_id ? \App\Models\Ukm::find(Auth::user()->ukm_id) : null;
        $role = Auth::user()->role;
        $gradient = 'from-blue-400 to-sky-300';
        $text = 'text-blue-500';
        $shadow = 'shadow-blue-400/40';
        $hoverText = 'hover:text-blue-500';
        $hoverBg = 'hover:bg-blue-50/80';
        
        if ($role === 'bem') {
            $gradient = 'from-emerald-600 to-teal-500';
            $text = 'text-emerald-600';
            $shadow = 'shadow-emerald-500/40';
            $hoverText = 'hover:text-emerald-600';
            $hoverBg = 'hover:bg-emerald-50/80';
        } elseif ($role === 'bpm') {
            $gradient = 'from-orange-600 to-amber-500';
            $text = 'text-orange-600';
            $shadow = 'shadow-orange-500/40';
            $hoverText = 'hover:text-orange-600';
            $hoverBg = 'hover:bg-orange-50/80';
        }
    @endphp"""

content = content.replace("    @php\n        $userUkm = Auth::user()->ukm_id ? \\App\\Models\\Ukm::find(Auth::user()->ukm_id) : null;\n    @endphp", php_block)

# Replace active classes
content = content.replace('from-blue-600 to-violet-600', '{{ $gradient }}')
content = content.replace('shadow-blue-500/30', '{{ $shadow }}')

# Replace hover and text classes (light mode only)
content = content.replace('hover:text-blue-700', '{{ $hoverText }}')
content = content.replace('hover:bg-blue-50/80', '{{ $hoverBg }}')
content = content.replace('text-indigo-500', '{{ $text }}')
content = content.replace('hover:bg-indigo-50', '{{ $hoverBg }}')

# Replace specific logo gradient
content = content.replace('from-indigo-500 to-purple-600', '{{ $gradient }}')

with open(member_file, 'w', encoding='utf-8') as f:
    f.write(content)

print("Updated member.blade.php")

# admin_ukm.blade.php replacements
admin_file = 'resources/views/layouts/admin_ukm.blade.php'
with open(admin_file, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace Tailwind config primary and accent to use blue-700
content = content.replace("'brand-primary': '#1e293b'", "'brand-primary': '#1d4ed8'") # blue-700
# Actually, the user asked for bg-gradient-to-r from-blue-700 to-blue-500. We can just replace bg-brand-accent with the gradient class.
content = content.replace('bg-brand-accent text-white shadow-sm', 'bg-gradient-to-r from-blue-700 to-blue-500 text-white shadow-md shadow-blue-600/40')
content = content.replace('bg-brand-accent', 'bg-gradient-to-r from-blue-700 to-blue-500')
content = content.replace('shadow-brand-accent/30', 'shadow-blue-600/40')
content = content.replace('text-brand-accent', 'text-blue-700')

with open(admin_file, 'w', encoding='utf-8') as f:
    f.write(content)

print("Updated admin_ukm.blade.php")


# superadmin.blade.php replacements
sa_file = 'resources/views/layouts/superadmin.blade.php'
with open(sa_file, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace('bg-brand-accent text-white shadow-sm', 'bg-gradient-to-r from-violet-700 to-indigo-600 text-white shadow-md shadow-violet-600/40')
content = content.replace('bg-brand-accent', 'bg-gradient-to-r from-violet-700 to-indigo-600')
content = content.replace('shadow-brand-accent/30', 'shadow-violet-600/40')
content = content.replace('text-brand-accent', 'text-violet-700')
content = content.replace('hover:text-brand-accent', 'hover:text-violet-700')
# In case primary is used
# content = content.replace('bg-brand-primary', 'bg-slate-900')

with open(sa_file, 'w', encoding='utf-8') as f:
    f.write(content)

print("Updated superadmin.blade.php")
