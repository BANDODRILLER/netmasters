<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Netmasters</title>
@include('home.script')
@include('home.styles')
@include('home.slider')
    <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <!-- CTA -->
            <a
                class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                href=""
            >
                <div class="flex items-center">
                    <svg
                        class="w-5 h-5 mr-2"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        ></path>
                    </svg><span>Netmasters</span>

                </div>
                <span>View more &RightArrow;</span>
            </a>
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table style="border: none" class="min-w-full divide-y divide-gray-200" loading="lazy" id="responsive-table">
                        <thead>

                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Day/Time</th>
                            <th class="px-4 py-3">Game</th>
                            <th class="px-4 py-3">1</th>
                            <th class="px-4 py-3">X</th>
                            <th class="px-4 py-3">2</th>
                            <th class="px-4 py-3 hide-on-mobile">Score</th>
                            <th class="px-4 py-3 hide-on-mobile">Tip</th>
                            <th class="px-4 py-3 hide-on-mobile">CS1</th>
                            <th class="px-4 py-3 hide-on-mobile">CS2</th>
                            <th class="px-4 py-3 hide-on-mobile">CS3</th>
                            <th class="px-4 py-3 hide-on-mobile">+1.5</th>
                            <th class="px-4 py-3 hide-on-mobile">-1.5</th>
                            <th class="px-4 py-3 hide-on-mobile">+2.5</th>
                            <th class="px-4 py-3 hide-on-mobile">-2.5</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <!-- Add a row for the league name -->

                        <!-- Iterate over fixtures for the current league -->
                        @foreach($table->take(1) as $t)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <!-- Your existing table rows go here -->
                                <td class="border-r">{{$t->day}} {{$t->match_datetime}}</td>
                                <td class="border-r">{{$t->home_team}} v {{$t->away_team}}</td>
                                <td class="border-r">{{$t->odds_1}}</td>
                                <td class="border-r">{{$t->odds_X}}</td>
                                <td class="border-r">{{$t->odds_2}}</td>
                                <td class="border-r hide-on-mobile">{{$t->score}}</td>
                                <td class="border-r hide-on-mobile">
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                                    >
                                      {{$t->tip}}
                                    </span>
                                </td>
                                <td class="border-r hide-on-mobile">{{$t->cs1}}</td>
                                <td class="border-r hide-on-mobile">{{$t->cs2}}</td>
                                <td class="border-r hide-on-mobile">{{$t->cs3}}</td>
                                <td class="border-r hide-on-mobile">{{$t->plus_1_5}}</td>
                                <td class="border-r hide-on-mobile">{{$t->minus_1_5}}</td>
                                <td class="border-r hide-on-mobile">{{$t->plus_2_5}}</td>
                                <td class="border-r hide-on-mobile">{{$t->minus_2_5}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    </div>
    </div>
    </body>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            function toggleColumns() {
                if ($(window).width() < 968) {
                    $('.hide-on-mobile').hide();
                } else {
                    $('.hide-on-mobile').show();
                }
            }

            toggleColumns();

            $(window).resize(toggleColumns);
        });
    </script>
    <style>
        /* Add some styling to the table */
        #responsive-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Adjust as needed */
        }

        /* Style the table header row */
        #responsive-table thead th {
            background-color: #f8f8f8; /* Light gray background */
            border-bottom: 2px solid #ddd; /* Bottom border */
            padding: 10px;
            text-align: left;
        }

        /* Style the table body rows */
        #responsive-table tbody tr {
            border-bottom: 1px solid #ddd; /* Bottom border for each row */
        }

        /* Style the table cells */
        #responsive-table td, #responsive-table th {
            padding: 10px;
        }

        /* Apply additional styles to specific columns if needed */
        #responsive-table td:nth-child(1),
        #responsive-table th:nth-child(1) {
            /* Styling for the first column */
        }

        #responsive-table td:nth-child(2),
        #responsive-table th:nth-child(2) {
            /* Styling for the second column */
        }

        /* Add more styles as needed */

    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>








</html>
