@extends('layouts.app')
@section('content')
    <div class="w-full h-full max-w-7xl mx-auto flex items-center bg-slate-800">
        <livewire:upload-invoice>
    </div>
    <!-- Include Dropzone.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />

    <script>

         // Function to initialize Dropzone
         function initializeDropzone() {
             const dropzoneElement = document.querySelector("#invoice-dropzone");
             
             if (dropzoneElement) {
                 // Initialize Dropzone for the form with the specific id
                 const myDropzone = new Dropzone(dropzoneElement, {
                        url: "{{ route('file.upload') }}", // Backend route for file uploads
                        paramName: "file", // The name that will be used to transfer the file
                        maxFilesize: 5, // Max file size in MB
                        acceptedFiles: ".jpg,.png,.pdf,.zip", // Allowed file types
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include CSRF token for security
                        },
                        init: function() {
                            this.on("success", function(file, response) {
                                console.log('File uploaded successfully:', response);
                                // alert('File uploaded successfully');
                            });

                            this.on("error", function(file, response) {
                                console.error('Error uploading file:', response);
                                alert('Error uploading file');
                            });

                            this.on("uploadprogress", function(file, progress) {
                                console.log('Upload progress: ', progress);
                            });
                        }
                    });
                } else {
                    console.error('Dropzone element not found');
                }
            }


        initializeDropzone();

        document.addEventListener('livewire:updated', function() {

            // initializeDropzone();
        });
    </script>

    <style>
        .dropzone .dz-preview.dz-file-preview .dz-image {
            background: transparent;
        }

        .dropzone .dz-preview.dz-file-preview .dz-image {
            padding: 0;
        }
        
        .dropzone .dz-preview {
            margin: 0;
            max-height: 50px;
        }

         /* Horizontal layout for uploaded files */
         .dz-preview {
            display: inline-block;
            margin-right: 10px;
        }

        /* Optional styling for uploaded file thumbnails */
        .dz-image {
            width: 100px;
            height: 100px;
        }

        .dz-details {
            text-align: center;
        }
    </style>
@endsection
