<div class="max-w-6xl mx-auto">
    <div class="flex justify-end m-2 p-2">
        <x-button wire:click="showPostModal">Create</x-button>
    </div>
    <div class="m-2 p-2">
        
    </div>
    <div class="div">
        <x-dialog-modal wire:model="showingPostModal">
          @if ($isEditMode)
          <x-slot name="title">Update Post</x-slot>
          @else
            <x-slot name="title">Create Post</x-slot>
          @endif
          <x-slot name="content">            
            <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
           <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-4">
                <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Post Title</label>
                <div class="mt-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                    <input type="text" name="title" id="title" wire:model.lazy="title" autocomplete="title" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="post enter here">
                  </div>
                </div>
                </div>
                </div>
                @error('title') <span class="text-red-400">{{ $message }}</span> @enderror  
                <br>
                <div
                x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                <div class="col-span-full">
          <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Photo</label>
          <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
          <div class="sm:col-span-3">
          @if ($oldImage)
                  Old Photo Preview:
                  <img src="{{ Storage::url($oldImage) }}">
          @endif
          @if ($newImage)
                  Photo Preview:
                  <img src="{{ $newImage->temporaryUrl() }}">
          @endif
          </div>   
          <div class="text-center">  
              <div class="mt-4 flex text-sm leading-6 text-gray-600">
            
                <label for="image" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                  <span>Upload a file</span>
                  <input id="image" name="image" type="file" wire:model="newImage" class="sr-only">
                 
                </label>
                <div x-show="isUploading">
                  <progress max="100" x-bind:value="progress"></progress>
              </div>
              </div>
              </div>
              <p class="text-xs leading-5 text-gray-600">drag and drop a PNG, JPG, GIF up to 10MB</p>
            </div>
           
            @error('newImage') <span class="text-red-400">{{ $message }}</span> @enderror  
          </div>
        </div>
      </div>
    </div>
    <br>
   
    <div class="col-span-full">
          <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Body</label>
          <div class="mt-2">
            <textarea id="body" name="body" rows="3" wire:model.lazy="body" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
          </div>
          @error('body') <span class="text-red-400">{{ $message }}</span> @enderror  
            </x-slot>
            <x-slot name="footer">
                <div class="mt-6 flex items-center justify-end gap-x-6">
                  @if ($isEditMode)
                  <x-button class="rounded-md bg-orange-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" wire:click="updatePost">Update</x-button>
                    @else
                    <x-button class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" wire:click="storePost">Save</x-button>  
                  @endif
               
                </div>
        </x-slot>
        </x-dialog-modal>
    </div>
    
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 dark:bg-gray-600 dark;text-gray-200">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500">Id</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500">Image</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500">Title</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-500">Body</th>
                    <th scope="col" class="relative px-6 py-3">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr></tr>
                  @foreach ($posts as $post)
                        <tr>
                            <td class="px-6 py-2 whitespace-nowrap">{{ $post->id }}</td>
                            <td class="px-6 py-2 whitespace-nowrap"><img class="w-8 h-8 rounded-full" src="{{ Storage::url($post->image) }}" /></td>
                            <td class="px-6 py-2 whitespace-nowrap">{{ $post->title }}</td>
                            <td class="px-6 py-2 whitespace-wrap">{{ $post->body }}</td>
                            <td class="px-6 py-2 text-right text-sm">
                              <div class="flex space-x-2">
                              <x-button class="bg-green-500 hover:bg-green-700" wire:click="showEditPostModal({{ $post->id }})">Edit</x-button>
                              <x-button class="bg-red-500 hover:bg-red-700" wire:click="deletePost({{ $post->id }})">Delete</x-button>
                              </div>
                            </td>
                         </tr>
                         
                  @endforeach        
                </tbody>
              </table>
              <div class="m-2 p-2">Pagination</div>
            </div>
          </div>
        </div>
 
</div>
