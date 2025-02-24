<!-- resources/views/categories/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trashed Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    @if (@session()->has('success'))
    @endif
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6"> Trashed Categories</h1>
        <a href="{{ route('categories.index') }}"
            class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 absolute top-10 right-10 shadow-lg">
            Back
        </a>


        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-300 text-gray-700 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Image</th>
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Deleted At</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($categories as $category)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6"><img src="{{ asset('storage/' . $category->image) }}" alt=""
                                width="80" height="100"></td>
                        <td class="py-3 px-6">{{ $category->id }}</td>
                        <td class="py-3 px-6">{{ $category->name }}</td>

                        <td class="py-3 px-6">{{ $category->status }}</td>
                        <td class="py-3 px-6">{{ $category->deleted_at->format('Y-m-d H:i:s') }}</td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- Edit Action -->
                                <form action="{{ route('categories.restore', $category->id) }}" method="POST">
                                    @csrf

                                    @method('PUT')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                        Restore
                                    </button>

                                    <!-- Delete Action -->
                                    <form action="{{ route('categories.force-delete', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        <!--form method spoofing to convert the method from post to delete or edit
                                    <input type ="hiddin" name="_methos" value="delete"-->
                                        <!-- directive method -->
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
</body>

</html>
