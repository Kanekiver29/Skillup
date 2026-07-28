<div class="ml-4">
    <form method="GET" action="/lang" class="inline">
        <select name="locale" onchange="this.form.submit()" class="bg-white border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>EN</option>
            <option value="es" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>ES</option>
        </select>
    </form>
</div>

