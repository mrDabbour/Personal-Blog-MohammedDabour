<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800">
            Categories List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <div class="mb-4">
                        <x-link :href="route('admin.categories.create')" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full">
                            Create New Category
                        </x-link>
                    </div>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 text-sm font-bold uppercase bg-gray-100 border-b text-gray-dark border-gray-light">
                                    #
                                </th>
                                <th class="px-6 py-4 text-sm font-bold uppercase bg-gray-100 border-b text-gray-dark border-gray-light">
                                    Name
                                </th>
                                <th class="px-6 py-4 text-sm font-bold uppercase bg-gray-100 border-b text-gray-dark border-gray-light"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 border-b border-gray-200">{{ $category->id }}</td>
                                <td class="px-6 py-4 border-b border-gray-200">{{ $category->name }}</td>
                                <td class="px-6 py-4 border-b border-gray-200">
                                    <x-link :href="route('admin.categories.edit', $category->id)" class="text-blue-500 hover:text-blue-700">
                                        Edit
                                    </x-link>

                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <x-button class="text-red-500 hover:text-red-700">Delete</x-button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
