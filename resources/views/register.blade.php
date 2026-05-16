@extends('base')

@section('content')
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="bg-white max-w-md mt-10 p-6 rounded-xl shadow-lg sm:mx-auto sm:w-full">
      <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="font-bold pb-6 text-2xl/9 text-gray-900">Sign up for new account</h2>
      </div>
      <form action="#" id="main_register_form" method="POST" class="group space-y-2">
        @csrf
        <div>
          <label for="fullname" class="block text-sm/6 font-medium text-gray-900">Full Name</label>
          <div class="mt-2">
            <input id="fullname" type="fullname" name="fullname" required autocomplete="fullname"
              class="block w-full rounded-md bg-white px-3.5 py-2.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-gray-600 sm:text-sm/6" />
          </div>
        </div>
        <div>
          <label for="email" class="block text-sm/6 font-medium text-gray-900">Email Address</label>
          <div class="mt-2">
            <input id="email" type="email" name="email" required autocomplete="email"
              class="block w-full rounded-md bg-white px-3.5 py-2.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-gray-600 sm:text-sm/6" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
          </div>
          <div class="mt-2">
            <input id="password" type="password" name="password" required autocomplete="current-password"
              class="block w-full rounded-md bg-white px-3.5 py-2.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-gray-600 sm:text-sm/6" />
          </div>
        </div>

        <div>
        <div class="flex items-center my-4 justify-between">
          <label for="consent" class="block text-sm/6 font-medium text-gray-900">
            <input type="checkbox" name="consent" id="consent" required value="yes"/>
            I agree to the Terms and Conditions. <a href="/" target="_blank" class="text-blue-700">Terms and Conditions</a>
          </label>
        </div>
      </div>

        <div class="flex g-recaptcha items-center justify-center my-4" data-sitekey="6LeWX-EsAAAAAHgm1XAGiabkyStycb4P6jD_sVI5"></div>
        <div class="notice_zone text-sm/6"></div>
        <div>
          <button type="submit"
            class="w-full rounded-md text-sm/6 font-semibold text-white bg-gray-900 px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white cursor-pointer">
            <span class="form_submit_text group-[.processing]:hidden">Create Account</span>
            <span class="form_loader group-[:not(.processing)]:hidden flex justify-center items-center">
              <svg aria-hidden="true" class="w-4 h-4 text-neutral-tertiary animate-spin fill-brand me-2" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="black"/>
              </svg>
              Please wait...
            </span>
          </button>
        </div>
      </form>

      <p class="mt-4 text-center text-sm/6 text-gray-900">
        Already a member?
        <a href="/login" class="font-semibold text-gray-900 hover:text-gray cursor-pointer">login here.</a>
      </p>
    </div>
  </div>

@endsection