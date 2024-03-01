<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Netmasters</title>
@include('home.script')
@include('home.styles')
@include('home.slider')
    <style>
        /* Style for the label */
        label {
            display: block;
            margin-bottom: 8px;
        }

        /* Style for the select element */
        #tableSelector {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Style for the option elements */
        #tableSelector option {
            font-size: 14px;
        }

    </style>
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
                    </svg>
                    <span>Select table of different leagues below</span>
                </div>
                <span>View more &RightArrow;</span>
            </a>
            <label for="tableSelector">Select a Table:</label>
            <select id="tableSelector" x-on:change="updateTable()">
                    <option value="">All tables</option>
                    <option value="Premier League Form (Last 6)">Premier League Form (Last 6)</option>
                    <option value="Championship Form (Last 6)">Championship Form (Last 6)</option>
                    <option value="League One Form (Last 6)">League One Form (Last 6)</option>
                    <option value="League Two Form (Last 6)">League Two Form (Last 6)</option>
                    <option value="National League Form (Last 6)">National League Form (Last 6)</option>
                    <option value="FA Cup Form (Last 6)">FA Cup Form (Last 6)</option>
                    <option value="EFL Cup Form (Last 6)">EFL Cup Form (Last 6)</option>
                    <option value="EFL Trophy Form (Last 6)">EFL Trophy Form (Last 6)</option>
                    <option value="FA Trophy Form (Last 6)">FA Trophy Form (Last 6)</option>
                    <option value="Scottish Premiership Form (Last 6)">Scottish Premiership Form (Last 6)</option>
                    <option value="Scottish Championship Form (Last 6)">Scottish Championship Form (Last 6)</option>
                    <option value="Scottish League One Form (Last 6)">Scottish League One Form (Last 6)</option>
                    <option value="Scottish League Two Form (Last 6)">Scottish League Two Form (Last 6)</option>
                    <option value="Scottish Cup Form (Last 6)">Scottish Cup Form (Last 6)</option>
                    <option value="Scottish League Cup Form (Last 6)">Scottish League Cup Form (Last 6)</option>
                    <option value="Scottish Challenge Cup Form (Last 6)">Scottish Challenge Cup Form (Last 6)</option>
                    <option value="Champions League Form (Last 6)">Champions League Form (Last 6)</option>
                    <option value="Europa League Form (Last 6)">Europa League Form (Last 6)</option>
                    <option value="Europa Conference League Form (Last 6)">Europa Conference League Form (Last 6)</option>
                    <option value="Form (Last 6)">Form (Last 6)</option>
                    <option value="National League South Form (Last 6)">National League South Form (Last 6)</option>
                    <option value="National League North Form (Last 6)">National League North Form (Last 6)</option>
                    <option value="MLS Form (Last 6)">MLS Form (Last 6)</option>
                    <option value="Spanish La Liga Form (Last 6)">Spanish La Liga Form (Last 6)</option>
                    <option value="German Bundesliga Form (Last 6)">German Bundesliga Form (Last 6)</option>
                    <option value="Italian Serie A Form (Last 6)">Italian Serie A Form (Last 6)</option>
                    <option value="French Ligue 1 Form (Last 6)">French Ligue 1 Form (Last 6)</option>
                    <option value="Belgian Pro League Form (Last 6)">Belgian Pro League Form (Last 6)</option>
                    <option value="Dutch Eredivisie Form (Last 6)">Dutch Eredivisie Form (Last 6)</option>
                    <option value="Portuguese Primeira Liga Form (Last 6)">Portuguese Primeira Liga Form (Last 6)</option>
                    <option value="Swiss Super League Form (Last 6)">Swiss Super League Form (Last 6)</option>
                    <option value="World Cup 2022 Form (Last 6)">World Cup 2022 Form (Last 6)</option>
                    <option value="Euro 2024 Form (Last 6)">Euro 2024 Form (Last 6)</option>
                    <option value="International Friendlies Form (Last 6)">International Friendlies Form (Last 6)</option>
                    <option value="UEFA Nations League Form (Last 6)">UEFA Nations League Form (Last 6)</option>
                    <option value="Asian International Qualifiers Form (Last 6)">Asian International Qualifiers Form (Last 6)</option>
                    <option value="CONCACAF International Qualifiers Form (Last 6)">CONCACAF International Qualifiers Form (Last 6)</option>
                    <option value="Africa World Cup 2026 Form (Last 6)">Africa World Cup 2026 Form (Last 6)</option>
                    <option value="CONMEBOL International Qualifiers Form (Last 6)">CONMEBOL International Qualifiers Form (Last 6)</option>
                    <option value="Oceania International Qualifiers Form (Last 6)">Oceania International Qualifiers Form (Last 6)</option>
                    <option value="World Cup 2023 Form (Last 6)">World Cup 2023 Form (Last 6)</option>
                    <option value="Spanish Copa del Rey Form (Last 6)">Spanish Copa del Rey Form (Last 6)</option>
                    <option value="German DFB Pokal Form (Last 6)">German DFB Pokal Form (Last 6)</option>
                    <option value="Italian Coppa Italia Form (Last 6)">Italian Coppa Italia Form (Last 6)</option>
                    <option value="French Coupe de France Form (Last 6)">French Coupe de France Form (Last 6)</option>
                    <option value="Danish Superliga Form (Last 6)">Danish Superliga Form (Last 6)</option>
                    <option value="Finnish Veikkausliiga Form (Last 6)">Finnish Veikkausliiga Form (Last 6)</option>
                    <option value="Norwegian Eliteserien Form (Last 6)">Norwegian Eliteserien Form (Last 6)</option>
                    <option value="Swedish Allsvenskan Form (Last 6)">Swedish Allsvenskan Form (Last 6)</option>
                    <option value="Japan J-League Form (Last 6)">Japan J-League Form (Last 6)</option>
                    <option value="China Super League Form (Last 6)">China Super League Form (Last 6)</option>
                    <option value="Turkish Super League Form (Last 6)">Turkish Super League Form (Last 6)</option>
                    <option value="Spanish Segunda Form (Last 6)">Spanish Segunda Form (Last 6)</option>
                    <option value="German 2. Bundesliga Form (Last 6)">German 2. Bundesliga Form (Last 6)</option>
                    <option value="Italian Serie B Form (Last 6)">Italian Serie B Form (Last 6)</option>
                    <option value="French Ligue 2 Form (Last 6)">French Ligue 2 Form (Last 6)</option>
                    <option value="Greek Super League Form (Last 6)">Greek Super League Form (Last 6)</option>
                    <option value="Czech 1 Liga Form (Last 6)">Czech 1 Liga Form (Last 6)</option>
                    <option value="Austria Bundesliga Form (Last 6)">Austria Bundesliga Form (Last 6)</option>
                    <option value="Polish Ekstraklasa Form (Last 6)">Polish Ekstraklasa Form (Last 6)</option>
                    <option value="Indian Super League Form (Last 6)">Indian Super League Form (Last 6)</option>
                    <option value="Portuguese Liga Pro Form (Last 6)">Portuguese Liga Pro Form (Last 6)</option>
                    <option value="Ukrainian Premier League Form (Last 6)">Ukrainian Premier League Form (Last 6)</option>
                    <option value="Club Friendlies Form (Last 6)">Club Friendlies Form (Last 6)</option>
                    <option value="U18 Premier League North Form (Last 6)">U18 Premier League North Form (Last 6)</option>
                    <option value="U18 Premier League South Form (Last 6)">U18 Premier League South Form (Last 6)</option>
                    <option value="Premier League 2, Division 1 Form (Last 6)">Premier League 2, Division 1 Form (Last 6)</option>
                    <option value="Japan J-League Cup Form (Last 6)">Japan J-League Cup Form (Last 6)</option>
                    <option value="China FA Cup Form (Last 6)">China FA Cup Form (Last 6)</option>
                    <option value="NASL Form (Last 6)">NASL Form (Last 6)</option>
                    <option value="Romanian Liga I Form (Last 6)">Romanian Liga I Form (Last 6)</option>
                    <option value="Northern Premier Form (Last 6)">Northern Premier Form (Last 6)</option>
                    <option value="Kenyan Premier League (old) Form (Last 6)">Kenyan Premier League (old) Form (Last 6)</option>
                    <option value="South Africa Premier League Form (Last 6)">South Africa Premier League Form (Last 6)</option>
                    <option value="Highland League Form (Last 6)">Highland League Form (Last 6)</option>
                    <option value="Lowland League Form (Last 6)">Lowland League Form (Last 6)</option>
                    <option value="Uganda Premier League Form (Last 6)">Uganda Premier League Form (Last 6)</option>
                    <option value="Southern Premier South Form (Last 6)">Southern Premier South Form (Last 6)</option>
                    <option value="Northern Div 1 East Form (Last 6)">Northern Div 1 East Form (Last 6)</option>
                    <option value="Northern Div 1 West Form (Last 6)">Northern Div 1 West Form (Last 6)</option>
                    <option value="Isthmian League North Form (Last 6)">Isthmian League North Form (Last 6)</option>
                    <option value="Isthmian League South Central Form (Last 6)">Isthmian League South Central Form (Last 6)</option>
                    <option value="Isthmian League South East Form (Last 6)">Isthmian League South East Form (Last 6)</option>
                    <option value="Southern Div 1 Central Form (Last 6)">Southern Div 1 Central Form (Last 6)</option>
                    <option value="Southern Div 1 South Form (Last 6)">Southern Div 1 South Form (Last 6)</option>
                    <option value="Kenyan Premier League Form (Last 6)">Kenyan Premier League Form (Last 6)</option>
                    <option value="South Korea K-League Form (Last 6)">South Korea K-League Form (Last 6)</option>
                    <option value="Nigeria Premier League Form (Last 6)">Nigeria Premier League Form (Last 6)</option>
                    <option value="Polish I Liga Form (Last 6)">Polish I Liga Form (Last 6)</option>
                    <option value="French National Form (Last 6)">French National Form (Last 6)</option>
                    <option value="Italian Serie C, Group A Form (Last 6)">Italian Serie C, Group A Form (Last 6)</option>
                    <option value="Italian Serie C, Group B Form (Last 6)">Italian Serie C, Group B Form (Last 6)</option>
                    <option value="Italian Serie C, Group C Form (Last 6)">Italian Serie C, Group C Form (Last 6)</option>
                    <option value="Welsh Premier League Form (Last 6)">Welsh Premier League Form (Last 6)</option>
                    <option value="Welsh Cup Form (Last 6)">Welsh Cup Form (Last 6)</option>
                    <option value="Ghana Premier League Form (Last 6)">Ghana Premier League Form (Last 6)</option>
                    <option value="Indonesian Liga 1 Form (Last 6)">Indonesian Liga 1 Form (Last 6)</option>
                    <option value="Pakistan Premier League Form (Last 6)">Pakistan Premier League Form (Last 6)</option>
                    <option value="Hong Kong Premier League Form (Last 6)">Hong Kong Premier League Form (Last 6)</option>
                    <option value="Singapore Premier League Form (Last 6)">Singapore Premier League Form (Last 6)</option>
                    <option value="Malaysian Super League Form (Last 6)">Malaysian Super League Form (Last 6)</option>
                    <option value="Bahraini Premier League Form (Last 6)">Bahraini Premier League Form (Last 6)</option>
                    <option value="Kuwaiti Premier League Form (Last 6)">Kuwaiti Premier League Form (Last 6)</option>
                    <option value="Oman Professional League Form (Last 6)">Oman Professional League Form (Last 6)</option>
                    <option value="Qatari Stars League Form (Last 6)">Qatari Stars League Form (Last 6)</option>
                    <option value="Saudi Professional League Form (Last 6)">Saudi Professional League Form (Last 6)</option>
                    <option value="UAE Pro League Form (Last 6)">UAE Pro League Form (Last 6)</option>
                    <option value="AFC Champions League Form (Last 6)">AFC Champions League Form (Last 6)</option>
                    <option value="AFC Cup Form (Last 6)">AFC Cup Form (Last 6)</option>
                    <option value="CAF Champions League Form (Last 6)">CAF Champions League Form (Last 6)</option>
                    <option value="CAF Confederation Cup Form (Last 6)">CAF Confederation Cup Form (Last 6)</option>
                    <option value="Copa Libertadores Form (Last 6)">Copa Libertadores Form (Last 6)</option>
                    <option value="Copa Sudamericana Form (Last 6)">Copa Sudamericana Form (Last 6)</option>
                    <option value="Recopa Sudamericana Form (Last 6)">Recopa Sudamericana Form (Last 6)</option>
                    <option value="A-League Form (Last 6)">A-League Form (Last 6)</option>
                    <option value="Australian FFA Cup Form (Last 6)">Australian FFA Cup Form (Last 6)</option>
                    <option value="Jamaican Premier League Form (Last 6)">Jamaican Premier League Form (Last 6)</option>
                    <option value="Trinidad and Tobago Pro League Form (Last 6)">Trinidad and Tobago Pro League Form (Last 6)</option>
                    <option value="CONCACAF Champions League Form (Last 6)">CONCACAF Champions League Form (Last 6)</option>
                    <option value="CONCACAF League Form (Last 6)">CONCACAF League Form (Last 6)</option>
                    <option value="Costa Rican Primera División Form (Last 6)">Costa Rican Primera División Form (Last 6)</option>
                    <option value="Honduran Liga Nacional Form (Last 6)">Honduran Liga Nacional Form (Last 6)</option>
                    <option value="Guatemalan Liga Nacional Form (Last 6)">Guatemalan Liga Nacional Form (Last 6)</option>
                    <option value="Salvadoran Primera División Form (Last 6)">Salvadoran Primera División Form (Last 6)</option>
                    <option value="Nicaraguan Primera División Form (Last 6)">Nicaraguan Primera División Form (Last 6)</option>
                    <option value="Panamanian LPF Form (Last 6)">Panamanian LPF Form (Last 6)</option>
                    <option value="Mexican Liga MX Form (Last 6)">Mexican Liga MX Form (Last 6)</option>
                    <option value="Mexican Ascenso MX Form (Last 6)">Mexican Ascenso MX Form (Last 6)</option>
                    <option value="US Major League Soccer Form (Last 6)">US Major League Soccer Form (Last 6)</option>
                    <option value="Canadian Premier League Form (Last 6)">Canadian Premier League Form (Last 6)</option>

            </select>




            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table id="footballTable" class="min-w-full divide-y divide-gray-200" loading="lazy" id="responsive-table">
                        <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">League</th>
                            <th class="px-4 py-3">Position</th>
                            <th class="px-4 py-3">team</th>
                            <th class="px-4 py-3">P</th>
                            <th class="px-4 py-3">W</th>
                            <th class="px-4 py-3">D</th>
                            <th class="px-4 py-3">L</th>
                            <th class="px-4 py-3">F</th>
                            <th class="px-4 py-3">A</th>
                            <th class="px-4 py-3">GD</th>
                            <th class="px-4 py-3">P</th>
                            <th class="px-4 py-3">BTTS</th>
                            <th class="px-4 py-3">last_6_results</th>
                            <th class="px-4 py-3">G15</th>
                            <th class="px-4 py-3">KM15</th>
                            <th class="px-4 py-3">Next match</th>


                        </tr>
                        </thead>
                        <tbody>

                        @foreach($table as $t)
                            @if(isset($t->table_name))
                            <tr data-league="{{$t->table_name}}" class="text-gray-700 dark:text-gray-400">
                                <td  class="px-4 py-3">{{$t->table_name}}
                                </td>
                                <td  class="px-4 py-3">{{$t->position}}
                                </td>
                                <td class="px-4 py-3">{{$t->team}}
                                </td>
                                <td class="px-4 py-3">{{$t->played}}
                                </td>
                                <td class="px-4 py-3">{{$t->win}}
                                </td>
                                <td class="px-4 py-3">{{$t->draw}}
                                </td>
                                <td class="px-4 py-3">{{$t->loss}}
                                </td>
                                <td class="px-4 py-3">{{$t->f}}
                                </td>
                                <td class="px-4 py-3">{{$t->attack}}
                                </td>
                                <td class="px-4 py-3">{{$t-> goal_difference}}
                                </td>
                                <td class="px-4 py-3">{{$t->points}}
                                </td>
                                <td class="px-4 py-3">{{$t->btts}}
                                </td>
                                <td class="px-4 py-3">{{$t->last_6_results}}
                                </td>
                                <td class="px-4 py-3">{{$t->g}}
                                </td>
                                <td class="px-4 py-3">{{$t->km}}
                                </td>
                                <td class="px-4 py-3">{{$t->Next_match}}
                                </td>
                            </tr>
                            @else
                                {{ Log::error('Row missing league name.') }}
                            @endif
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </main>
    </div>
    </div>

    <script>
        function updateTable() {
            // Get the selected value
            var selectedValue = document.getElementById("tableSelector").value;

            // Get all the table data rows
            var tableRows = document.getElementsByTagName("tr");

            // Show or hide rows based on the selected value
            for (var i = 0; i < tableRows.length; i++) {
                // Skip the first row (header row)
                if (i === 0) {
                    continue;
                }

                var leagueName = tableRows[i].getAttribute("data-league");
                console.log("Selected Value: " + selectedValue + ", League Name: " + leagueName);
                if (selectedValue === "" || leagueName === selectedValue) {
                    tableRows[i].style.display = "table-row";
                } else {
                    tableRows[i].style.display = "none";
                }
            }
        }
    </script>

    </body>


</html>
