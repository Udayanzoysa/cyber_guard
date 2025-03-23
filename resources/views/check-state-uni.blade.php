<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cyber Guard</title>
        
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">   
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{  asset('js/jquery.validate.min.js')}}"></script>

        <style>
        h3 {
            margin-bottom: 15px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        .custom-button {
            padding: 10px 20px;
            border: 1px solid black;
            cursor: pointer;
            background: white;
            border-radius: 5px;
        }
        .custom-button:hover {
            background: lightgray;
        }
        .selected-button {
            background-color: #28a745;
            color: white;
            border: none;
        }
        #eligibility-message {
            display: none;
            color: red;
            font-weight: bold;
            margin-top: 15px;
        }
        .exit-button {
            margin-top: 10px;
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    </head>
    
    <body>
        <main>
            <section class="hero-section d-flex justify-content-center align-items-center" id="check-uni">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-12 mb-4">
                            <div class="custom-block bg-white shadow-lg p-4">
                                <h3>Are you currently a State University Undergraduate?</h3>
                                <div class="button-group">
                                    <button id="undergradYes" class="custom-button" onclick="selectOption('undergraduate', true, 'undergradYes', 'undergradNo')">Yes</button>
                                    <button id="undergradNo" class="custom-button" onclick="selectOption('undergraduate', false, 'undergradNo', 'undergradYes')">No</button>
                                </div>
                                <h3>Are you enrolled in a Non-IT degree program?</h3>
                                <div class="button-group">
                                    <button id="nonITYes" class="custom-button" onclick="selectOption('nonIT', true, 'nonITYes', 'nonITNo')">Yes</button>
                                    <button id="nonITNo" class="custom-button" onclick="selectOption('nonIT', false, 'nonITNo', 'nonITYes')">No</button>
                                </div>
                                <button class="custom-button" onclick="checkEligibility()">Continue</button>
                                <p id="eligibility-message">Sorry.. This system is mainly targeted for the State University Non-IT undergraduates</p>
                                <button class="exit-button" onclick="exitPage()">Exit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-padding section-bg d-none" id="formEligible">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12">
                            <h3 class="mb-4 pb-2">We'd love to hear from you</h3>
                        </div>

                        <div class="col-lg-6 col-12">
    <form action="#" method="post" class="custom-form contact-form" role="form" id="checkUserForm">
    @csrf
        <div class="row">
            <!-- Gender Selection -->
            <div class="col-lg-12 col-12">
                <label for="gender">Gender</label><br>
                <input type="radio" id="male" name="gender" value="male"> Male
                <input type="radio" id="female" name="gender" value="female"> Female
            </div>

            <!-- University Selection -->
            <div class="col-lg-12 col-12">
                <div class="form-floating">
                    <select name="university" id="university" class="form-control" required>
                        <option value="">Select State University</option>
                        <option value="uoc">University of Colombo</option>
                        <option value="uop">University of Peradeniya</option>
                        <option value="uom">University of Moratuwa</option>
                        <option value="uor">University of Ruhuna</option>
                        <option value="eusl">Eastern University, Sri Lanka</option>
                        <option value="susl">Sabaragamuwa University of Sri Lanka</option>
                        <option value="usjp">University of Sri Jayewardenepura</option>
                        <option value="wusl">Wayamba University of Sri Lanka</option>
                        <option value="uvpa">University of the Visual and Performing Arts</option>
                        <option value="ou">The Open University of Sri Lanka</option>
                        <option value="vau">University of Vavuniya</option>
                        <option value="rjt">Rajarata University of Sri Lanka</option>
                        <option value="slu">South Eastern University of Sri Lanka</option>
                        <option value="gzu">Gampaha Wickramarachchi University of Indigenous Medicine</option>
         
                        <!-- Add more universities as needed -->
                    </select>
                    <label for="university">University</label>
                </div>
            </div>

            <!-- Field of Study Selection -->
            <div class="col-lg-12 col-12">
                <div class="form-floating">
                    <select name="field_of_study" id="field_of_study" class="form-control" required>
                        <option value="">Select Field of Study</option>
                        <option value="arts">Arts</option>
                        <option value="engineering">Engineering</option>
                        <option value="science">Science</option>
                        <option value="technology">Technology</option>
                    </select>
                    <label for="field_of_study">Field of Study</label>
                </div>
            </div>

            <!-- Year of Study Selection -->
            <div class="col-lg-12 col-12">
                <div class="form-floating">
                    <select name="year_of_study" id="year_of_study" class="form-control" required>
                        <option value="">Select Year of Study</option>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                    </select>
                    <label for="year_of_study">Year of Study</label>
                </div>
            </div>

            <!-- District of Residence Selection -->
            <div class="col-lg-12 col-12">
                <div class="form-floating">
                    <select name="district_of_residence" id="district_of_residence" class="form-control" required>
                        <option value="">Select District</option>
                        <option value="ampara">Ampara</option>
                        <option value="anuradhapura">Anuradhapura</option>
                        <option value="badulla">Badulla</option>
                        <option value="batticaloa">Batticaloa</option>
                        <option value="colombo">Colombo</option>
                        <option value="galle">Galle</option>
                        <option value="gampaha">Gampaha</option>
                        <option value="hambantota">Hambantota</option>
                        <option value="jaffna">Jaffna</option>
                        <option value="kalutara">Kalutara</option>
                        <option value="kandy">Kandy</option>
                        <option value="kegalle">Kegalle</option>
                        <option value="kilinochchi">Kilinochchi</option>
                        <option value="kurunegala">Kurunegala</option>
                        <option value="mannar">Mannar</option>
                        <option value="matale">Matale</option>
                        <option value="matara">Matara</option>
                        <option value="monaragala">Monaragala</option>
                        <option value="mullaitivu">Mullaitivu</option>
                        <option value="nuwara_eliya">Nuwara Eliya</option>
                        <option value="polonnaruwa">Polonnaruwa</option>
                        <option value="puttalam">Puttalam</option>
                        <option value="ratnapura">Ratnapura</option>
                        <option value="trincomalee">Trincomalee</option>
                        <option value="vavuniya">Vavuniya</option>
                        <!-- Add more districts as needed -->
                    </select>
                    <label for="district_of_residence">District of Residence</label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-lg-4 col-12 ms-auto">
                <button type="submit" class="form-control">Submit</button>
            </div>
        </div>
    </form>
</div>

                    </div>
                </div>
            </section>
        </main>

        <script>
        let isUndergraduate = null;
        let isNonIT = null;
        $("#formEligible").hide();

        function selectOption(question, answer, selectedId, unselectedId) {
            if (question === 'undergraduate') {
                isUndergraduate = answer;
            } else if (question === 'nonIT') {
                isNonIT = answer;
            }
            
            document.getElementById(selectedId).classList.add("selected-button");
            document.getElementById(unselectedId).classList.remove("selected-button");
        }

        function checkEligibility() {
    if (isUndergraduate === true && isNonIT === true) {
        // Hide the "check-uni" section
        $("#check-uni").hide();
        
        // Show the "formEligible" section
        $("#formEligible").removeClass("d-none").show();
        
        // Hide eligibility message
        $("#eligibility-message").hide();
    } else {
        // Show eligibility message if not eligible
        $("#eligibility-message").show();
    }
}

        function exitPage() {
            window.location.replace("/");
        }

        $(document).ready(function() {
            $("#checkUserForm").validate({
                rules: {
                    gender: { required: true },
                    university: { required: true },
                    field_of_study: { required: true },
                    year_of_study: { required: true },
                    district_of_residence: { required: true},
                    
                },
                messages: {
                    gender: { required: "Name is required"},
                    university: { required: "Name is required", minlength: "Minimum 3 characters" },
                    field_of_study: { required: "Name is required" },
                    year_of_study: { required: "Email is required"},
                    district_of_residence: { required: "Password is required" }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: "{{ route('check-state-uni.submit') }}",
                        type: "POST",
                        data: $("#checkUserForm").serialize(),
                        success: function(response) {
                            alert(response.success);
                            $("#checkUserForm")[0].reset();
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                alert(value[0]); // Show error messages
                            });
                        }
                    });
                }
            });
        });
    </script>
    </body>
</html>
