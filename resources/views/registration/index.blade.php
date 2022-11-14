@extends('theme.public.default', ['page_title' => 'Registration'])
@section('content')
    <div class="row">
        <div class="col-lg-6">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Please fill-up the following:</h5>

                    <!-- Floating Labels Form -->
                    <form class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                <label for="floatingName">First Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                <label for="floatingName">Last Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="floatingEmail" placeholder="Your Email">
                                <label for="floatingEmail">Your Email</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingPassword" placeholder="Cellphone #">
                                <label for="floatingPassword">Cellphone #</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;"></textarea>
                                <label for="floatingTextarea">Address</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingSelect" aria-label="Title">
                                    <option selected>Kuya</option>
                                    <option value="1">Ate</option>
                                    <option value="2">Bunso</option>
                                    <option value="3">Aspirant</option>
                                </select>
                                <label for="floatingSelect">Title</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingSelect" aria-label="Club">
                                    <option selected>DFEC</option>
                                    <option value="1">MAAEC</option>
                                    <option value="2">MREC</option>
                                    <option value="3">GFEC</option>
                                    <option value="4">TWEC</option>
                                    <option value="5">FNEC</option>
                                    <option value="6">MEC</option>
                                    <option value="7">INLEC</option>
                                    <option value="8">RMLEC</option>
                                </select>
                                <label for="floatingSelect">Club</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingZip" placeholder="No. of Ticket">
                                <label for="floatingZip">No. of Ticket</label>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End floating Labels Form -->

                </div>
            </div>

        </div>
        <div class="col-lg-6">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Please fill-up the following for your guest/s:</h5>

                    <!-- Floating Labels Form -->
                    <form class="row g-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                <label for="floatingName">Relation</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                <label for="floatingName">Full Name</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                <label for="floatingName">Relation</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                <label for="floatingName">Full Name</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                <label for="floatingName">Relation</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                <label for="floatingName">Full Name</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                <label for="floatingName">Relation</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your Name">
                                <label for="floatingName">Full Name</label>
                            </div>
                        </div>

                    </form><!-- End floating Labels Form -->

                </div>
            </div>

        </div>
    </div>
@endsection