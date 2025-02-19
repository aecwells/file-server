<select {{ $attributes->merge(['class' => 'form-control border rounded w-full py-2 px-3 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500']) }}>
    {{ $slot }}
</select>
