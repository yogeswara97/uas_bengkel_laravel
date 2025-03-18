<x-layout class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-10 ">
    <x-slot:title>Profile</x-slot:title>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="w-screen sm:max-w-3xl md:bg-gray-800 p-6 md:rounded-lg md:shadow-lg mx-auto">

        <div class="grid max-w-2xl mx-auto mt-8">
            <div class="flex flex-col items-center space-y-5 sm:flex-row sm:space-y-0 sm:space-x-8">

                <img class="object-cover w-40 h-40 p-1 rounded-full ring-2"
                    src="{{ $user->profile_picture ? $user->profile_picture : 'asset/images/dashboard/Profile_avatar_placeholder_large.png' }}"
                    alt="Bordered avatar">

                <div class="flex flex-col space-y-3 w-full sm:w-auto">
                    <button type="button"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3.5 px-7 rounded-lg transition duration-300 font-semibold">
                        Change picture
                    </button>
                    <form action="{{ route('profile.destroyImage', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this profile picture?');">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" value="{{ $user->profile_picture }}" name="profile_picture">
                        <button type="submit"
                            class="w-full bg-white hover:bg-indigo-200 text-indigo-700 py-3.5 px-7 rounded-lg transition duration-300 font-semibold">
                            Delete picture
                        </button>
                    </form>
                </div>
            </div>

            <form action="{{ route('profile.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="items-center mt-8 sm:mt-14 text-[#202142]">

                    <div
                        class="flex flex-col items-center w-full mb-2 space-x-0 space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0 sm:mb-6">
                        <div class="w-full">
                            <label for="first_name"
                                class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">First
                                name</label>
                            <div class="mt-2">
                                <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}"
                                    autocomplete="first_name"
                                    class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="last_name"
                                class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Last name</label>
                            <div class="mt-2">
                                <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}"
                                    autocomplete="last_name"
                                    class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex flex-col items-center w-full mb-2 space-x-0 space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0 sm:mb-6">
                        <div class="w-full">
                            <label for="gender"
                                class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Gender</label>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <input id="male" type="radio" value="male" name="gender"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $user->gender == 'male' ? 'checked' : '' }}>
                                    <label for="male"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 ml-2">Male</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="female" type="radio" value="female" name="gender"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $user->gender == 'female' ? 'checked' : '' }}>
                                    <label for="female"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 ml-2">Female</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="dob"
                                class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Date of
                                Birth</label>
                            <div class="mt-2">
                                <input type="date" id="dob" name="dob" value="{{ $user->dob }}"
                                    autocomplete="dob"
                                    class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 sm:mb-6">
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Your
                            email</label>
                        <div class="mt-2">
                            <input type="email" id="email" name="email" value="{{ $user->email }}"
                                autocomplete="email"
                                class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6"
                                readonly>
                        </div>
                    </div>

                    <div class="mb-2 sm:mb-6">
                        <label for="phone"
                            class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Phone</label>
                        <div class="mt-2">
                            <input type="text" id="phone" name="phone" autocomplete="phone"
                                value="{{ $user->phone }}"
                                class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="mb-2 sm:mb-6">
                        <label for="address" class="block text-sm font-medium leading-6 text-white">Street
                            address</label>
                        <div class="mt-2">
                            <input type="text" name="address" id="address" autocomplete="address"
                                value="{{ $user->address }}"
                                class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="bio"
                            class="block mb-2 text-sm font-medium text-indigo-900 dark:text-white">Bio</label>
                        <div class="mt-2">
                            <textarea id="bio" name="bio" rows="4"
                                class="block p-2.5 w-full text-sm text-white bg-gray-700 rounded-md shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6"
                                placeholder="Write your bio here...">{{ $user->bio }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">Save</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-layout>
