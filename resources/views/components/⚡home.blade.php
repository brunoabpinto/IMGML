<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ImageService;

new class extends Component {
    use WithFileUploads;

    public $file;
    public $image;
    public $userImagePath; // Store only the path

    public function mount()
    {
        $this->generateImage();
    }

    public function generateImage()
    {
        $this->image = app(ImageService::class)->render('https://picsum.photos/200/200');
    }

    public function refreshImage()
    {
        $this->generateImage();
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|image|max:2048',
        ]);

        $this->userImagePath = $this->file->path();
    }

    // Computed property - generates HTML on-demand
    public function getUserImageProperty()
    {
        if (!$this->userImagePath) {
            return null;
        }

        return app(ImageService::class)->render($this->userImagePath);
    }

    public function download()
    {
        if (!$this->userImage) {
            return;
        }

        return response()->streamDownload(
            function () {
                echo $this->userImage;
            },
            'imgml.html',
            [
                'Content-Type' => 'text/html',
            ],
        );
    }
};
?>

<div class="container mx-auto flex flex-col px-6 text-center max-md:gap-12 max-md:py-8 md:flex-row md:justify-between">
    <div class="flex flex-col items-center justify-center space-y-8 overflow-y-hidden">
        <h1 class="text-3xl text-white/60 md:text-left md:text-5xl">
            There are no images on this page
        </h1>
        <span class="mb-5 cursor-pointer overflow-hidden rounded-lg shadow-2xl" wire:click="refreshImage">
            {!! $this->image !!}
        </span>
        <h3 class="mb-3 text-2xl text-white/50">No, not even this one</h3>
    </div>

    <div class="flex flex-col items-center justify-center space-y-8 overflow-y-hidden">
        <h1 class="text-center text-3xl text-white/60 md:text-left md:text-5xl">
            Upload an image!
        </h1>

        @if ($this->userImage)
            <div class="space-y-4" wire:transition>
                <div class="overflow-hidden rounded-lg shadow-2xl">
                    {!! $this->userImage !!}
                </div>

                <button
                    class="cursor pointer flex cursor-pointer items-center rounded-xl bg-yellow-300 px-5 py-2 font-semibold text-white shadow"
                    wire:click="download">
                    <svg class="mr-2 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                    </svg>
                    <span>download HTML</span>
                </button>
            </div>
        @else
            <label for="fileUpload" wire:transition
                class="duration-750 h-[200px] w-[200px] cursor-pointer overflow-hidden rounded-lg border-2 border-dashed border-white/50 shadow-2xl transition-all hover:bg-white/10">
            </label>
        @endif

        <input id="fileUpload" type="file" accept="image/jpeg" wire:model="file" class="hidden" />
    </div>
</div>
