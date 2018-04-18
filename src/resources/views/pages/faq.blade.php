@extends('layouts.main', ['type' => $type])

@section('content')
    <div id="content_topics_faq">
        <div id="page_faq">
            <h3>
                FAQ
            </h3>


            <!-- perguntas não colapsadas-->
            <div id="accordion">
                <!-- Pergunta 1 -->
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                What is covered by the Amazonas Money Back Guarantee?
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            You're covered by the eBay Money Back Guarantee for just about every purchase on eBay.co.uk
                            when you pay with PayPal. As with every programme like this, there are some rules:

                            <ul>
                                <li>
                                    Amazonas Money Back Guarantee protects you in case you do not receive your item or if
                                    the item is not as described in the listing. If this happens, you need to tell your
                                    seller within 30 days from your actual or latest estimated delivery date.
                                </li>

                                <li>
                                    The programme is designed to protect purchases that are usually sent by post – over
                                    99% of listings on eBay are. It doesn’t include vehicles, real estate, businesses
                                    for sale, digital goods or services.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Pergunta 2 -->
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="true" aria-controls="collapseTwo">
                                I haven't received an item – what should I do?
                            </button>
                        </h5>
                    </div>

                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            The amount of time that it takes for an item to arrive often depends on the postage method
                            that you selected when you bought the item. You can review the estimated delivery time on
                            the Order Details page.

                            If the estimated delivery time has already passed, you should contact the seller. To do so,
                            go back to contact us and send as an email explain the case.
                        </div>
                    </div>
                </div>

                <!-- Pergunta 3 -->
                <div id="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree"
                                    aria-expanded="true" aria-controls="collapseThree">
                                I received an item that doesn't match the listing description, what should I do?
                            </button>
                        </h5>
                    </div>

                    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            If you received an item that's wrong, damaged or otherwise not as described, you should
                            contact us so we can quickly help you with the issue.
                        </div>
                    </div>
                </div>

                <!-- Pergunta 4 -->
                <div id="card">
                    <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour"
                                    aria-expanded="true" aria-controls="collapseFour">
                                I received an item that doesn't match the listing description, what should I do?
                            </button>
                        </h5>
                    </div>

                    <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            If you received an item that's wrong, damaged or otherwise not as described, you should
                            contact us so we can quickly help you with the issue.
                        </div>
                    </div>
                </div>
                
                <!-- Pergunta 5 -->
                <div id="card">
                    <div class="card-header" id="headingFive">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFive"
                                    aria-expanded="true" aria-controls="collapseFive">
                                I received the correct item, but I changed my mind and don't want it any more – what
                                should I do?
                            </button>
                        </h5>
                    </div>

                    <div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="#accordion">
                        <div class="card-body">
                            Go to the contact us page and send as an email with the account and we open a process.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
