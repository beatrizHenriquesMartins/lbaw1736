@extends('layouts.main', ['type' => $type])

@section('content')
    <div id="page_about_us">
        <div id="title">
            <h1>
                About Us
            </h1>
        </div>

        <div id="content_topics">
            <div id="whatWeAre">
                <h3>
                    What are we?
                </h3>

                <p id="description">
                    Nowadays, Portuguese products are in high demand worldwide. Culture, history, weather and
                    food are just some of the reasons the brand ”Made in Portugal” is being sought after
                    internationally. After some research, we identified a lack of a specialized Internet retailer
                    that offers premium selected Portuguese products and that’s why Amazonas was born. We want to
                    offer a unique online experience to satisfy the expectations of Lusophiles all around the world.
                </p>
            </div>

            <div id="team_info">
                <h3>
                    Team
                </h3>

                <div class="container">
                    <div> <!-- class="card-columns col-sm-1" -->
                        <!-- Beatriz de Henriques Martins -->
                        <div id="member" class="card-columns col-sm-2">
                            <div id="photo">
                                <img src="./images/team_photos/photo_beatriz_1.jpg" alt="beatriz" height="250"
                                     width="250" > <!-- class="img-responsive" -->
                            </div>

                            <div>
                                <div id="name_member_team">
                                    <h5>
                                        Beatriz de Henriques Martins
                                    </h5>
                                </div>

                                <div>
                                    <i class="material-icons">
                                        link
                                    </i>

                                    <i>
                                        https://www.linkedin.com/in/beatrizdehenriquesmartins/
                                    </i>
                                </div>
                            </div>
                        </div>

                        <!-- Francisco Tuna Andrade -->
                        <div id="member" class="card-columns col-sm-2">
                            <div id="photo">
                                <img src="./images/team_photos/photo_francisco_1.jpg" alt="beatriz" height="250"
                                     width="250" > <!-- class="img-responsive" -->
                            </div>

                            <div>
                                <div id="name_member_team">
                                    <h5>
                                        Francisco Tuna Andrade
                                    </h5>
                                </div>

                                <div>
                                    <i class="material-icons">
                                        link
                                    </i>

                                    <i>
                                        https://www.linkedin.com/in/beatrizdehenriquesmartins/
                                    </i>
                                </div>
                            </div>
                        </div>

                        <!-- Luís Miguel Santos Monteiro Saraiva -->
                        <div id="member" class="card-columns col-sm-2">
                            <div id="photo">
                                <img src="./images/team_photos/photo_luis_1.jpg" alt="beatriz" height="250"
                                     width="250" > <!-- class="img-responsive" -->
                            </div>

                            <div>
                                <div id="name_member_team">
                                    <h5>
                                        Luís Miguel Santos Monteiro Saraiva
                                    </h5>
                                </div>

                                <div>
                                    <i class="material-icons">
                                        link
                                    </i>

                                    <i>
                                        https://www.linkedin.com/in/beatrizdehenriquesmartins/
                                    </i>
                                </div>
                            </div>
                        </div>

                        <!-- Ricardo Filipe Amaro Saleiro Abreu -->
                        <div id="member" class="card-columns col-sm-2">
                            <div id="photo">
                                <img src="./images/team_photos/photo_ricardo.jpg" alt="beatriz" height="250"
                                     width="250"> <!-- class="img-responsive" -->
                            </div>

                            <div>
                                <div id="name_member_team">
                                    <h5>
                                        Ricardo Filipe Amaro Saleiro Abreu
                                    </h5>
                                </div>

                                <div>
                                    <i class="material-icons">
                                        link
                                    </i>

                                    <i>
                                        https://www.linkedin.com/in/beatrizdehenriquesmartins/
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
