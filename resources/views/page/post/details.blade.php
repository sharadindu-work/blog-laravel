<x-user-layout>

    <div class="flex justify-between px-4 mx-auto min-w-screen-xl py-5 ">
            <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                <header class="mb-4 lg:mb-6 not-format">
                    <address class="flex items-center mb-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                            <img class="mr-4 w-16 h-16 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-2.jpg" alt="{{$post->user->name}}">
                            <div>
                                <a href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-white">{{$post->user->name}}</a>

                                <p class="text-base text-gray-500 dark:text-gray-400"><time pubdate datetime="2022-02-08" title="February 8th, 2022">{{date('M. j, Y', strtotime($post->post_date))}}</time></p>
                            </div>
                        </div>
                    </address>
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white"> </h1>
                </header>
                <p class="lead"> {{$post->content}}</p>

                <section class="not-format">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion ({{$post->comments->count()}})</h2>
                    </div>
                    @auth
                        @if(in_array("user", auth()->user()->getRoleNames()->toArray()))
                            <form class="mb-6" method="post" action="{{route('user.comment.store',$post->id)}}">
                                @csrf
                                <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <label for="comment" class="sr-only">Your comment</label>
                                    <textarea id="comment" name="comment" rows="6"
                                              class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                                              placeholder="Write a comment..." required></textarea>
                                    @error('comment')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    Post comment
                                </button>
                            </form>
                        @endif
                    @endauth

                    @foreach($post->comments as $comment)
                        <article class="p-6 mb-6 text-base bg-white border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <footer class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <p class="inline-flex items-center mr-3 font-semibold text-sm text-gray-900 dark:text-white"><img
                                            class="mr-2 w-6 h-6 rounded-full"
                                            src="https://flowbite.com/docs/images/people/profile-picture-3.jpg"
                                            alt="Bonnie Green">{{$comment->user->name}}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-03-12" title="March 12th, 2022">{{date('M. j, Y', strtotime($comment->user->created_at))}}</time></p>
                                </div>
                            </footer>
                            <p>{{$comment->comment}}</p>
                        </article>
                    @endforeach
                </section>
            </article>
        </div>
</x-user-layout>
