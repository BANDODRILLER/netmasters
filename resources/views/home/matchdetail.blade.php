<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Netmasters</title>
    @include('home.script')
    @include('home.styles')
    @include('home.slider')
    @foreach($table as $fixtures)

        <main  class="h-full overflow-y-auto" style="padding-bottom: 100px">
            <div class="container px-6 mx-auto grid" style="padding-top: 50px">
                <!-- New Table -->
                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto" style="padding-bottom: 50px">
                        <div class="container" style="padding-bottom:30px ;font-size: 0.8rem ">
                            <!-- div contain home_team image -->
                            <div class="team-container" style="--bg-color:#01e100;--text-color:#fff;">
                                <div class="loader" style="--clr:#01e100;--i:1;">
                                    <img style="width: 100px" src="{{ $fixtures->home_team_logo_url }}" alt="{{ $fixtures->home_team }}">
                                </div>
                                <div class="label" style="text-align: center;padding-bottom: 20px;padding-top: 10px">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg--100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ $fixtures->home_team }}
                                </span>
                                </div>
                                <!-- Inside the loop where you display fixtures -->
                                <div class="label" style="text-align: center; padding-bottom: 20px">
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg--100 rounded-full dark:bg-red-700 dark:text-red-100">
                                    FORM -   {{ optional($teamData->where('team', $fixtures->home_team)->first())->last_6_results }}

                                </span>

                                </div>

                                <div class="label" style="text-align: center; padding-bottom: 20px">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg--100 rounded-full dark:bg-green-700 dark:text-green-100"> PPG -
                             @if(optional($teamData->where('team', $fixtures->home_team)->first())->played != 0)
                                        {{ number_format(optional($teamData->where('team', $fixtures->home_team)->first())->points / optional($teamData->where('team', $fixtures->home_team)->first())->played, 2) }}
                                    @else
                                        N/A
                                    @endif


                                </span>
                                </div>


                            </div>

                            <div class="new" style="--clr:#f50076;--i:2; background-color: black; color: white; padding: 20px;border-radius: 15%">
                                <div style="text-align: center;">
                                    <div class="date">{{ $fixtures->formattedDate }}</div>
                                    <div class="score" style="font-size: 2rem; font-weight: bold; line-height: 1.2; color: var(--clr);">{{ $fixtures->score ?: '- :  -' }}</div>
                                    <div id="score-{{ $fixtures->id }}" class="status" style="color: var(--clr);"> {{ $fixtures->score ? 'UPLOADED' : 'UPLOADING' }}</div>
                                </div>
                            </div>


                            <!-- div contain away_team image -->
                            <!-- div contain away_team image -->
                            <div class="team-container" style="--bg-color:#00e6fd;--text-color:#fff;">
                                <div class="loader" style="--clr:#00e6fd;--i:3;">
                                    <img style="width: 100px" src="{{ $fixtures->away_team_logo_url }}" alt="/assets/img/logo.png">
                                </div>
                                <div class="label" style="text-align: center;padding-bottom: 20px;padding-top: 10px">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg--100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ $fixtures->away_team }}
                                </span>
                                </div>
                                <div class="label" style="text-align: center; padding-bottom: 20px">
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg--100 rounded-full dark:bg-red-700 dark:text-red-100">
                                    FORM -  {{ optional($teamData->where('team', $fixtures->away_team)->first())->last_6_results }}

                                </span>
                                </div>

                                <div class="label" style="text-align: center; padding-bottom: 20px">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg--100 rounded-full dark:bg-green-700 dark:text-green-100"> PPG -

                                 @if(optional($teamData->where('team', $fixtures->away_team)->first())->played != 0)
                                        {{ number_format(optional($teamData->where('team', $fixtures->away_team)->first())->points / optional($teamData->where('team', $fixtures->away_team)->first())->played, 2) }}
                                    @else
                                        N/A
                                    @endif


                                </span>
                                </div>
                            </div>
                        </div>

                        <!-- Responsive Table -->
                        <div class="responsive-table" style="align-items: center">
                            <table style="border: none" class="min-w-full divide-y divide-gray-200" loading="lazy" id="responsive-table">

                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">


                                    <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3">1</th>
                                    <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3">X</th>
                                    <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3">2</th>
                                    <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3 hide-on-mobile">Tip</th>
                                    <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3 hide-on-mobile">CS1</th>
                                    <th style="font-size: 0.8rem;background-color: black" class="px-4 py-3 hide-on-mobile">CS2</th>
                                    <th  style="font-size: 0.8rem;background-color: black"class="px-4 py-3 hide-on-mobile">CS3</th>

                                </tr>
                                <!-- ... Header section ... -->
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                <!-- Row for league name -->
                                <tr class="text-gray-700 dark:text-gray-400">
                                    {{--                                {{ $leagueName }}--}}
                                </tr>

                                <!-- Row for match details -->
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">{{ $fixtures->odds_1 }}</td>
                                    <td class="px-4 py-3">{{ $fixtures->odds_X }}</td>
                                    <td class="px-4 py-3">{{ $fixtures->odds_2 }}</td>
                                    <td class="px-4 py-3 hide-on-mobile">{{ $fixtures->tip ?: 'N/A' }}</td>
                                    <td class="px-4 py-3 hide-on-mobile">{{ $fixtures->cs1 ?: 'N/A' }}</td>
                                    <td class="px-4 py-3 hide-on-mobile">{{ $fixtures->cs2 ?: 'N/A' }}</td>
                                    <td class="px-4 py-3 hide-on-mobile">{{ $fixtures->cs3 ?: 'N/A' }}</td>

                                </tr>
                                <!-- ... Additional rows if needed ... -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Responsive Table -->
                        <!-- Responsive Table for Team Data -->
                        <div class="responsive-table" style="align-items: center">
                            <h3 style="padding-bottom: 20px; align-items: center;text-align: center">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg--100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    STANDING FOR LAST 6 GAMES
                                </span>
                            </h3>
                            <table style="border: none" class="min-w-full divide-y divide-gray-200" loading="lazy" id="responsive-table">
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Pos</th>
                                    <th class="px-4 py-3">TEAM</th>
                                    <th class="px-4 py-3">P</th>
                                    <th class="px-4 py-3">W</th>
                                    <th class="px-4 py-3">D</th>
                                    <th class="px-4 py-3">L</th>
                                    <th class="px-4 py-3">PTS</th>
                                </tr>
                                @php $counter = 1; @endphp
                                @foreach($teamData as $team)
                                    <tr class="text-gray-700 dark:text-gray-400 {{ $team->team == $home_team ? 'bg-red-500' : '' }} {{ $team->team == $away_team ? 'bg-red-500' : '' }}">
                                        <td class="px-4 py-3">{{ $counter++ }}</td>
                                        <td class="px-4 py-3">{{ $team->team }}</td>
                                        <td class="px-4 py-3">{{ $team->played }}</td>
                                        <td class="px-4 py-3">{{ $team->win }}</td>
                                        <td class="px-4 py-3">{{ $team->draw }}</td>
                                        <td class="px-4 py-3">{{ $team->loss }}</td>
                                        <td class="px-4 py-3">{{ $team->points }}</td>
                                    </tr>
                                @endforeach
                            </table>

                        </div>

                    </div>
                </div>
            </div>
            @endforeach

            <script>
                // Dynamically set text color based on background color
                document.addEventListener("DOMContentLoaded", function () {
                    var teamContainers = document.querySelectorAll(".team-container");

                    teamContainers.forEach(function (container) {
                        var bgColor = getComputedStyle(container).getPropertyValue("--bg-color");
                        var textColor = getComputedStyle(container).getPropertyValue("--text-color");

                        // Check if the background is dark, then set text color to light, and vice versa
                        var isDarkBackground = isDarkColor(bgColor);
                        container.style.color = isDarkBackground ? "#fff" : "#000";
                    });

                    // Function to check if a color is dark
                    function isDarkColor(color) {
                        var rgb = color.match(/\d+/g);
                        var brightness = (rgb[0] * 299 + rgb[1] * 587 + rgb[2] * 114) / 1000;
                        return brightness < 128;
                    }
                });
            </script>

        </main>


        </div>
        </div>
        </body>
        <style>
            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 20px;
            }

            .responsive-table {
                overflow-x: auto;
                font-size: 0.8rem;
                padding: 20px; /* Adjust padding as needed */
            }

            .responsive-table table {
                border-collapse: collapse;
                width: 100%;
            }

            .responsive-table th,
            .responsive-table td {
                border: 1px solid black;
                padding: 8px;
                text-align: center;
            }

            .responsive-table th {
                background-color: black;
                color: white;
            }


        </style>




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
                            // Check if the score is available
                            if (score.score !== null) {
                                // Update the score in the corresponding table cell
                                $('#score-' + score.id).text(score.score);
                                // Optionally, update the status to 'SCORE' if score is available
                                $('#score-' + score.id).removeClass('status-upcoming').addClass('status-finished').text('SCORE');
                            } else {
                                // If the score is not available, update the status to 'UPCOMING'
                                $('#score-' + score.id).removeClass('status-finished').addClass('status-upcoming').text('UPCOMING');
                            }
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
                    window.history.replaceState({}, '', '/date?new=' + encodedDate);

                    // Reload the page
                    window.location.href = window.location.href;
                });
            });
        </script>
@include('home.footer')
</html>
