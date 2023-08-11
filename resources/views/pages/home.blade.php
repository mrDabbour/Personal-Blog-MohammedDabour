<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Latest
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="-my-8 divide-y-2 divide-gray-100">
                        @foreach ($articles as $article)
                            <div class="flex flex-wrap py-8 md:flex-nowrap">
                                <div class="flex flex-col flex-shrink-0 mb-6 md:w-64 md:mb-0">
                                    @if($article->image)
                                    <img src="{{ asset('storage/uploads/' . $article->image) }}" width="100" height="100">
                                    @else
                                        <img src="{{ asset('no_image.jpg') }}" width="100" height="100">
                                    @endif
                                    <span
                                        class="font-semibold text-gray-700 title-font">{{ $article->category->name }}</span>
                                    <span
                                        class="mt-1 text-sm text-gray-500">{{ $article->created_at->format('d F Y') }}</span>
                                </div>
                                <div class="md:flex-grow">
                                    <div class="space-y-6">
                                        <div>
                                            <h2 class="text-2xl font-medium tracking-tight text-gray-900 title-font">{{ $article->title }}</h2>
                                            <div class="flex flex-wrap">
                                                @foreach ($article->tags as $tag)
                                                    <span class="mr-3 text-sm font-medium uppercase">#{{ $tag->name }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <x-nav-link href="{{ route('articles.show', $article) }}">Read More
                                        <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor"
                                             stroke-width="2" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5l7 7-7 7"></path>
                                        </svg>
                                    </x-nav-link>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
