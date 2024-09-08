<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="fastname" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastname" placeholder="Last Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="d-flex p-2 justify-content-between gap-5">
                                <button onclick="onRegistration()" class="btn mt-3 w-50  bg-gradient-primary">Complete</button>
                                <a href="{{ url('userlogin') }}"type="button" class="btn mt-3 w-50 btn btn-secondary btn-lg">Sign In</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


  async function onRegistration() {

        let email = document.getElementById('email').value;
        let fastname = document.getElementById('fastname').value;
        let lastname = document.getElementById('lastname').value;
        let mobile = document.getElementById('mobile').value;
        let password = document.getElementById('password').value;

        if(email.length===0){
            errorToast('Email is required')
        }
        else if(lastname.length===0){
            errorToast('First Name is required')
        }
        else if(lastname.length===0){
            errorToast('Last Name is required')
        }
        else if(mobile.length===0){
            errorToast('Mobile is required')
        }
        else if(password.length===0){
            errorToast('Password is required')
        }
        else{
            showLoader();
            let res=await axios.post("/userRegistretion",{
                email:email,
                fastname:fastname,
                lastname:lastname,
                mobile:mobile,
                password:password
            })
            hideLoader();
            document.write(email);
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message']);
                setTimeout(function (){
                    window.location.href='/userlogin'
                },2000)
            }
            else{
                errorToast(res.data['message'])
            }
        }
    }
</script>
