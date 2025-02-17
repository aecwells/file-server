<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ISO Image Upload') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <label for="collection" class="block mb-2 text-gray-700 dark:text-gray-300">Collection (optional):</label>
                    <input type="text" id="collection" class="border p-2 rounded w-full mb-4 bg-gray-100 dark:bg-gray-800 dark:text-white border-gray-300 dark:border-gray-700 focus:ring focus:ring-indigo-400">

                    <div class="col-span-full">
                        <span class="block text-sm font-medium text-gray-900 dark:text-gray-300">ISO Image</span>
                        <div id="drop-zone" class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-300 dark:border-gray-600 px-6 py-10 cursor-pointer bg-gray-50 dark:bg-gray-800">
                            <div class="text-center">
                                <svg class="mx-auto size-12 text-gray-400 dark:text-gray-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex text-sm text-gray-600 dark:text-gray-300">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-indigo-600 dark:bg-indigo-500 font-semibold text-white px-3 py-1 focus-within:ring-2 focus-within:ring-indigo-400 focus-within:ring-offset-2 hover:bg-indigo-500 dark:hover:bg-indigo-400">
                                        <span>Upload a file</span>
                                        <input id="file-upload" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-2">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">ISO up to 15GB</p>
                            </div>
                        </div>
                    </div>
                    
                    
                     <!-- Alert Component -->
                    

                    <!-- End Alert Component -->

                    <div id="file-info" class="hidden mt-4 p-3 bg-gray-100 dark:bg-gray-800 rounded-lg text-gray-900 dark:text-gray-200">
                        <p><strong>File Name:</strong> <span id="file-name"></span></p>
                        <p><strong>Size:</strong> <span id="file-size"></span></p>
                    </div>
                    <div id="upload-progress" class="mt-4 hidden">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 h-4 rounded">
                            <div id="progress-bar" class="h-4 bg-green-500 rounded" style="width: 0%;"></div>
                        </div>
                        <p id="progress-text" class="text-center mt-2 text-sm text-gray-600 dark:text-gray-300">0%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/resumablejs"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let collection = document.getElementById("collection");
            let dropZone = document.getElementById("drop-zone");
            let fileInput = document.getElementById("file-upload");
            let fileInfo = document.getElementById("file-info");
            let fileNameSpan = document.getElementById("file-name");
            let fileSizeSpan = document.getElementById("file-size");
            let progressBar = document.getElementById("progress-bar");
            let progressText = document.getElementById("progress-text");

            let resumable = new Resumable({
                target: "{{ route('api.upload.store') }}",
                method: 'POST', // Ensure POST is being used
                query: function () {
                    return { collection: document.getElementById('collection').value };
                },
                fileType: ['iso'],
                chunkSize: 1 * 1024 * 1024, // 1MB
                simultaneousUploads: 3,
                testChunks: false,
                throttleProgressCallbacks: 1,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                fieldName: "file" // ✅ Ensure the uploaded file is sent as "file"
            });

            resumable.assignDrop(dropZone);
            resumable.assignBrowse(fileInput);

            resumable.on('fileAdded', function (file) {
                // Show file information
                fileInfo.classList.remove("hidden");
                fileNameSpan.textContent = file.fileName;
                fileSizeSpan.textContent = (file.size / (1024 * 1024)).toFixed(2) + " MB";
                //document.getElementById('collection').value = '';
                // Show progress bar
                document.getElementById('upload-progress').classList.remove('hidden');
                progressText.textContent = "Uploading... 0%";

                resumable.upload();
            });

            resumable.on('fileProgress', function (file) {
                let progress = Math.floor(file.progress() * 100);
                progressBar.style.width = progress + '%';
                progressText.textContent = "Uploading... " + progress + '%';
            });

            resumable.on('fileSuccess', function (file, message) {
                try {
                    let response = JSON.parse(message);
                    progressText.textContent = response.message;
                } catch (e) {
                    progressText.textContent = "Upload successful, but failed to parse server response.";
                }
            });

            resumable.on('fileError', function (file, message) {
                try {
                    let response = JSON.parse(message);
                    progressText.textContent = response.message;
                } catch (e) {
                    progressText.textContent = "Upload Failed";
                }
            });
        });
    </script>
</x-app-layout>
