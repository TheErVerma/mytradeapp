@php
    use Illuminate\Support\Number;
@endphp
@extends('base')

@section('content')
    <!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> -->
    <!--
                          This example requires updating your template:

                          ```
                          <html class="h-full bg-gray-100">
                          <body class="h-full">
                          ```
                        -->
    <div class="min-h-full">
        <div class="mx-auto max-w-full flex flex-col gap-[20px] mt-[80px]">
            <div class="border-1 p-[20px] border-default border-dashed rounded-2xl">
                <ol class="grid grid-cols-3 gap-4">
                    @foreach ($symbols as $symbol => $title)
                        @php
                        $symbol_data = $apiObj::fetchStockData($symbol);
                        @endphp
                        @if(!is_array($symbol_data) && property_exists($symbol_data, 'name'))
                            <li>
                                <div class="border w-full relative inline-flex flex-col gap-4 p-6 rounded-[10px] bg-blue-700 hover:bg-blue-600 text-white transition-all">

                                    <h2>{{ucwords($symbol_data->name)}}</h2>
                                    <div class="flex gap-4 items-center">
                                        <p class="text-4xl">{{ Number::currency($symbol_data->price, in: 'USD') }}</p>
                                        <span class="bg-green-600 px-2 py-1 text-sm rounded-[100px]">{{strtoupper($symbol_data->ticker)}}</span>
                                    </div>
                                    <a class="absolute w-full h-full left-0 top-0" href="/symbols/{{strtolower($symbol_data->ticker)}}"></a>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </div>
            <div class="border-1 border-default border-dashed rounded-2xl">

                <!-- Calender -->
                <section class="relative py-8 sm:p-8">
                    <div class="max-w-7xl w-full mx-auto">
                        
                        <div class="border border-gray-200">
                            <div class="grid grid-cols-7  divide-gray-200 border-b border-gray-200">
                                <div
                                    class="p-3.5 flex flex-col sm:flex-row items-center justify-between border-r border-gray-200">
                                    <span class="text-sm font-medium text-gray-500">Sun</span>
                                    <span class="text-sm font-medium text-gray-900">09</span>
                                </div>
                                <div
                                    class="p-3.5 flex flex-col sm:flex-row items-center justify-between border-r border-gray-200">
                                    <span class="text-sm font-medium text-gray-500">Mon</span>
                                    <span class="text-sm font-medium text-gray-900">10</span>
                                </div>
                                <div
                                    class="p-3.5 flex flex-col sm:flex-row items-center justify-between border-r border-gray-200">
                                    <span class="text-sm font-medium text-gray-500">Tue</span>
                                    <span class="text-sm font-medium text-gray-900">11</span>
                                </div>
                                <div
                                    class="p-3.5 flex flex-col sm:flex-row items-center justify-between border-r border-gray-200">
                                    <span class="text-sm font-medium text-gray-500">Wed</span>
                                    <span class="text-sm font-medium text-gray-900">12</span>
                                </div>
                                <div
                                    class="p-3.5 flex flex-col sm:flex-row items-center justify-between border-r border-gray-200">
                                    <span class="text-sm font-medium text-gray-500">Thu</span>
                                    <span class="text-sm font-medium text-gray-900">13</span>
                                </div>
                                <div
                                    class="p-3.5 flex flex-col sm:flex-row items-center justify-between border-r border-gray-200">
                                    <span class="text-sm font-medium text-gray-500">Fri</span>
                                    <span class="text-sm font-medium text-gray-900">14</span>
                                </div>
                                <div class="p-3.5 flex flex-col sm:flex-row items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500">Sat</span>
                                    <span class="text-sm font-medium text-gray-900">15</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-7 divide-gray-200">
                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-b border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">27</span>
                                </div>
                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-b border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">28</span>
                                </div>
                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-b border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">29</span>
                                </div>
                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-b border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">30</span>
                                </div>
                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-b border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">31</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">1</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">2</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">3</span>
                                    <span class="hidden lg:block text-xs font-medium text-gray-500">Meeting with marketing
                                        department</span>
                                    <span class="lg:hidden w-2 h-2 rounded-full bg-gray-400"></span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">4</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">5</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">6</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">7</span>
                                    <span class="hidden lg:block text-xs font-medium text-gray-500">Developer Meetup</span>
                                    <span class="lg:hidden w-2 h-2 rounded-full bg-gray-400"></span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">8</span>
                                </div>
                                <div
                                    class="p-3.5  border-b  border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">9</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">10</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">11</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-white flex items-center justify-center w-7 h-7 rounded-full bg-indigo-600">12</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">13</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">14</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">15</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">16</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">17</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">18</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">19</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">20</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">21</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">22</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">23</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">24</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">25</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">26</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">27</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">28</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-r border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">29</span>
                                </div>
                                <div
                                    class="p-3.5  border-b border-gray-200   xl:aspect-auto  lg:h-28 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">30</span>
                                </div>
                                <div
                                    class="p-3.5    xl:aspect-auto  lg:h-28 border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-900 flex items-center justify-center w-7 h-7 rounded-full ">31</span>
                                </div>
                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">1</span>
                                </div>
                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">2</span>
                                </div>
                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">3</span>
                                </div>
                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">4</span>
                                    <span class="hidden lg:block text-xs font-medium text-gray-500">Meet with friends <br>
                                        9PM</span>
                                    <span class="lg:hidden w-2 h-2 rounded-full bg-gray-400"></span>
                                </div>

                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">5</span>
                                </div>
                                <div
                                    class="p-3.5 bg-gray-50   xl:aspect-auto  lg:h-28 border-r border-gray-200 flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100">
                                    <span
                                        class="text-xs font-semibold text-gray-500 flex items-center justify-center w-7 h-7 rounded-full ">6</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:hidden py-8 px-2.5 ">
                            <div class="bg-gray-50 w-full rounded-xl">
                                <div class="p-3 w-full flex items-center justify-between group transition-all duration-300">
                                    <div class="flex flex-col gap-2">
                                        <span class="text-sm font-medium text-gray-900">Meet with friends</span>
                                        <div class="flex items-center gap-2.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M12 8.99998V13L15 16M3 5.12132L5.10714 3M20.998 5.12657L18.8909 3.00525M20 13C20 17.4183 16.4183 21 12 21C7.58172 21 4 17.4183 4 13C4 8.5817 7.58172 4.99998 12 4.99998C16.4183 4.99998 20 8.5817 20 13Z"
                                                    stroke="black" stroke-width="1.6" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                            <span class="text-xs font-medium text-gray-600">9AM</span>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 rounded border border-gray-400 text-xs font-medium text-gray-900 opacity-0 transition-all duration-500 group-hover:opacity-100">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>



@endsection