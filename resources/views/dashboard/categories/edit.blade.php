<!-- resources/views/categories/create.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Edit Category</h1>

        <!-- Form Card -->
        <div class="bg-white border border-gray-200 shadow-md rounded-lg p-6">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" id="name" name="name" required value="{{$category->name}}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Parent Category -->
                <div class="mb-4">
                    <label for="parent_id" class="block text-gray-700 font-medium mb-2">Parent Category</label>
                    <select id="parent_id" name="parent_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Primary Category</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}" @selected($category->parent_id == $parent->id) >{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>


                <!-- Slug -->
                <div class="mb-4">
                    <label for="slug" class="block text-gray-700 font-medium mb-2">Slug</label>
                    <input type="text" id="slug" name="slug" required value="{{ $category->slug }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
           <!-- the textarea does not have a value attribute-->
                    <textarea id="description" name="description" rows="4"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{$category->description}}</textarea>
                </div>

                <!-- Image -->
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-medium mb-2">Image</label>
                    <input type="file" id="image" name="image"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                @if($category->image)
                <img src="{{ asset('storage/' .$category->image) }}" alt="" width="80" height="100">
                @endif
                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                    <select id="status" name="status"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="active" {{ $category->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="archived" {{ $category->status === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <a href="{{ route('categories.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Cancel</a>
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
