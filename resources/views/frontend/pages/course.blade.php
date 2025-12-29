<!-- Courses Start -->
<div id="courses" class="container-fluid px-0 py-5">
    <div class="row mx-0 justify-content-center pt-5">
        <div class="col-lg-6">
            <div class="section-title text-center position-relative mb-4">
                <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Our Courses</h6>
                <h1 class="display-4">Checkout Our Courses</h1>
            </div>
        </div>
    </div>

    <div class="owl-carousel courses-carousel">
        @foreach($courses as $course)
        <div class="courses-item position-relative">
            <img class="img-fluid" src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
            <div class="courses-text">
                <h4 class="text-center px-3">{{ $course->title }}</h4>
                <div class="border-top w-100 mt-3">
                    <div class="d-flex justify-content-between p-4">
                        <span><i class="fa fa-user mr-2"></i>{{ $course->instructor }}</span>
                        <span><i class="fa fa-star mr-2"></i>{{ $course->rating }} <small>({{ $course->reviews }})</small></span>
                    </div>
                </div>
                <div class="w-100 bg-white text-center p-3">
                    <a class="btn btn-dark btn-sm px-4 py-2" href="{{ route('course.detail', ['id' => $course->id]) }}">
                        Course Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Sign Up Section -->
<div class="row justify-content-center bg-image mx-0 mb-5">
    <div class="col-lg-6 py-5">
        <div class="bg-white p-5 my-5 rounded shadow-lg">
            <h1 class="text-center mb-4">39% Off For New Students</h1>
            <form>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control bg-light border-0" placeholder="Your Name" style="padding: 30px 20px;">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="email" class="form-control bg-light border-0" placeholder="Your Email" style="padding: 30px 20px;">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <select class="custom-select bg-light border-0 px-3" style="height: 60px;">
                                <option selected>Select A Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-primary btn-block" type="submit" style="height: 60px;">Sign Up Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Courses End -->
