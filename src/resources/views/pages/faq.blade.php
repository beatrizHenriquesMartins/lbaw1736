@extends('layouts.main', ['type' => $type])

@section('content')
    <div id="content_topics_faq">
        <div id="page_faq">
            <h3>
                FAQ
            </h3>
        </div>

        <!-- perguntas não colapsadas-->
        <div id="accordion">
            <!-- Pergunta 1 -->
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                aria-expanded="true" aria-controls="collapseOne">
                            Didn't receive an item
                        </button>
                    </h5>
                </div>
            </div>

            <!-- resposta pergunta -->
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    The Amazonas covers your purchase price plus original shipping for virtually all
                    items on eBay.com. We guarantee you’ll get the item you ordered or your money back.

                    If you paid for an item and haven’t received it, there are a few things you can do.
                </div>
            </div>


            <!-- Pergunta 2 -->
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                aria-expanded="true" aria-controls="collapseOne">
                            How much time my delivery
                        </button>
                    </h5>
                </div>
            </div>

            <!-- resposta pergunta -->
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    Saddly we don't have any physics shop right one!
                </div>
            </div>
        </div>
    </div>
@endsection
