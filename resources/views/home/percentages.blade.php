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
                    <label style="position: absolute; top: 0; left: 0; padding: 10px; font-family: 'Arial', sans-serif; font-size: 16px; color: #333;" for="tableSelector">Select a Table:</label>
                    <select id="tableSelector" onchange="filterOdds()" style="margin-top: 10px; padding: 8px; font-family: 'Arial', sans-serif; font-size: 14px; border: 1px solid #ccc; border-radius: 5px;">
                        <option disabled selected hidden>Filter by percentages</option>
                        <option id="above90">Above 90%</option>
                        <option id="above80">Above 80%</option>
                        <option id="above70">Above 70%</option>
                        <option id="above60">Above 60%</option>
                        <option id="above50">Above 50%</option>
                        <option id="above40">Above 40%</option>
                        <option id="above30">Above 30%</option>
                        <option id="above20">Above 20%</option>
                        <option id="above10">Above 10%</option>
                    </select>

                    <input style="float: right; padding-bottom: 20px"  type="date" id="calendarFilter" name="new">
                    <span id="selectedDatePlaceholder"></span>


                    @foreach($table->groupBy('league') as $league => $fixtures)
                        @php
                            // Remove "Fixtures" from the league string
                            $leagueName = str_replace(' Fixtures', '', $league);

                            // Get the maximum number of columns in any group
                            $columnsArray = $fixtures->pluck(['odds_1', 'odds_X', 'odds_2', 'score', 'tip', 'cs1', 'cs2', 'cs3', 'plus_1_5', 'minus_1_5', 'plus_2_5', 'minus_2_5'])->filter()->toArray();

                            // Check if the array is not empty before calculating the maximum
                            $maxColumns = !empty($columnsArray) ? max(array_map('count', $columnsArray)) : 0;
                        @endphp

                        <table style="border: none" class="min-w-full divide-y divide-gray-200" loading="lazy" id="responsive-table">
                            <thead>
                            <tr>
                                <th style="background-color: black;font-size: 0.8rem" colspan="{{ $maxColumns + 14 }}" class="text-center">
                <span class="inline-block px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                    {{ $leagueName }}
                </span>
                                </th>
                            </tr>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <!-- Dynamically generate table header based on the maximum number of columns -->
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3">Time</th>
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3">Game</th>

                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3">1</th>
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3">X</th>
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3">2</th>
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3 hide-on-mobile">Score</th>
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3 hide-on-mobile">Tip</th>
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3 hide-on-mobile">CS1</th>
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3 hide-on-mobile">CS2</th>
                                <th  style="font-size: 0.8rem;background-color: black"class="px-4 py-3 hide-on-mobile">CS3</th>
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3 hide-on-mobile">+1.5</th>
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3 hide-on-mobile">-1.5</th>
                                <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3 hide-on-mobile">+2.5</th>
                                <th  style="font-size: 0.8rem;background-color: black"class="px-4 py-3 hide-on-mobile">-2.5</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            <!-- Add a row for the league name -->
                            @foreach($fixtures as $t)
                                <tr class="text-gray-700 dark:text-gray-400"
                                    data-odds1="{{$t->odds_1}}"
                                    data-oddsX="{{$t->odds_X}}"
                                    data-odds2="{{$t->odds_2}}">

                                    <!-- Match Time -->
                                    <td style="font-size: 0.8rem" class="border-r">
                                        @php
                                            $matchTime = preg_match('/\s(\d{2}:\d{2})/', $t->match_datetime, $matches) ? $matches[1] : '';
                                            if (!empty($matchTime)) {
                                                $dateTime = DateTime::createFromFormat('H:i', $matchTime);
                                                $dateTime->modify('+3 hours');
                                                echo $dateTime->format('H:i');
                                            }
                                        @endphp
                                    </td>

                                    <!-- Teams -->
                                    <td style="font-size: 0.8rem" class="border-r">
                                        <a href="{{ route('matchdetails', ['id' => $t->id]) }}" class="text-gray-700 dark:text-gray-400 block">
                                            <div style="padding-bottom: 7px" class="team-container">
                                                <img style="width: 20px;height: 20px" src="{{ $t->home_team_logo_url }}" alt="{{ $t->home_team }}" class="team-logo">
                                                <span class="team-name">{{ $t->home_team }} </span>
                                            </div>
                                        </a>
                                        <a href="{{ route('matchdetails', ['id' => $t->id]) }}" class="text-gray-700 dark:text-gray-400 block">
                                            <div class="team-container">
                                                <img style="width: 20px;height: 20px" src="{{ $t->away_team_logo_url }}" alt="{{ $t->away_team }}" class="team-logo">
                                                <span class="team-name">{{ $t->away_team }}</span>
                                            </div>
                                        </a>
                                    </td>

                                    <!-- Odds -->
                                    @foreach (['odds_1', 'odds_X', 'odds_2'] as $odd)
                                        <a href="{{ route('matchdetails', ['id' => $t->id]) }}" class="text-gray-700 dark:text-gray-400 block">
                                            <td style="font-size: 0.8rem" class="border-r">{{ $t->$odd }}</td>
                                        </a>
                                    @endforeach

                                    <!-- Score -->
                                    <a href="{{ route('matchdetails', ['id' => $t->id]) }}" class="text-gray-700 dark:text-gray-400 block">
                                        <td id="score-{{ $t->id }}" style="font-size: 0.8rem" class="border-r hide-on-mobile">{{ $t->score }}</td>
                                    </a>

                                    <!-- Tip -->
                                    <a href="{{ route('matchdetails', ['id' => $t->id]) }}" class="text-gray-700 dark:text-gray-400 block">
                                        <td style="font-size: 0.8rem" class="border-r hide-on-mobile">
                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg--100 rounded-full dark:bg-green-700 dark:text-green-100">
                    {{ $t->tip }}
                </span>
                                        </td>
                                    </a>

                                    <!-- Additional Data -->
                                    @foreach (['cs1', 'cs2', 'cs3', 'plus_1_5', 'minus_1_5', 'plus_2_5', 'minus_2_5'] as $data)
                                        <a href="{{ route('matchdetails', ['id' => $t->id]) }}" class="text-gray-700 dark:text-gray-400 block">
                                            <td style="font-size: 0.8rem" class="border-r hide-on-mobile">{{ $t->$data }}</td>
                                        </a>
                                    @endforeach

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    @endforeach

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
        function updateScores() {
            $.ajax({
                url: "{{ route('get.updated.scores') }}",
                method: 'GET',
                success: function (data) {
                    // Update scores in the view based on the returned data
                    // You may need to adjust this based on your data structure
                    data.forEach(function (score) {
                        // Update the score in the corresponding table cell
                        $('#score-' + score.id).text(score.score);
                    });
                },
                error: function (error) {
                    console.log('Error fetching updated scores:', error);
                }
            });
        }

        // Periodically update scores every 30 seconds
        // Periodically update scores every second
        setInterval(updateScores, 1000);


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



        $(document).ready(function () {
            // Function to get the query parameter from the URL
            function getQueryParam(name) {
                var urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

            // Get the initial date from the URL or use today's date
            var initialDateParam = getQueryParam("new");
            var initialDate = initialDateParam ? new Date(initialDateParam).toISOString().split('T')[0] : new Date().toISOString().split('T')[0];

            // Set the initial date in the input field
            $("#calendarFilter").val(initialDate);

            // $("#selectedDatePlaceholder").text("Selected Date: " + initialDate);

            // Attach change event to the calendar filter
            $("#calendarFilter").on("change", function () {
                var selectedDate = $(this).val();

                // Update the placeholder text
                // $("#selectedDatePlaceholder").text("Selected Date: " + selectedDate);

                // Use encodeURIComponent to handle special characters in the date
                var encodedDate = encodeURIComponent(selectedDate);

                // Update the URL with the selected date as a parameter
                window.history.replaceState({}, '', '/percentagedate?new=' + encodedDate);

                // Reload the page
                window.location.href = window.location.href;
            });
        });

        function filterOdds() {
            var selectedOption = document.getElementById("tableSelector");
            var selectedPercentage = parseInt(selectedOption.value.replace(/\D/g, ''));

            var tables = document.querySelectorAll("table[id='responsive-table']");

            tables.forEach(function (table) {
                var rows = table.querySelectorAll("tr[data-odds1]");

                var shouldHideTable = true;

                rows.forEach(function (row) {
                    var odds1 = parseFloat(row.getAttribute("data-odds1"));
                    var oddsX = parseFloat(row.getAttribute("data-oddsX"));
                    var odds2 = parseFloat(row.getAttribute("data-odds2"));

                    if (odds1 > selectedPercentage || oddsX > selectedPercentage || odds2 > selectedPercentage) {
                        shouldHideTable = false;
                        row.style.display = ""; // Show the row
                    } else {
                        row.style.display = "none"; // Hide the row
                    }
                });

                if (shouldHideTable) {
                    table.style.display = "none"; // Hide the entire table group
                } else {
                    table.style.display = ""; // Show the entire table group
                }
            });
        }


    </script>
    <style>
        .team-container {
            display: flex;
            align-items: center;
        }

        .team-logo {
            border-radius: 50%; /* Make the logo round */
            margin-right: 8px; /* Adjust as needed for spacing between logo and name */
        }

        .team-name {
            max-width: 350px; /* Adjust the max-width as needed */
            white-space: normal; /* Set white-space to normal */
            word-break: break-all; /* Use word-break to break after each word */
            display: inline-block;
        }

        /* Add some styling to the table */
        #responsive-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Adjust as needed */
            table-layout: auto; /* Allow the table to adjust its width based on content */
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
        #responsive-table td,
        #responsive-table th {
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


    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>








</html>
