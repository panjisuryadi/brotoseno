

@if(!request()->routeIs('app.pos.*'))

<footer class="c-footer">
    <div>{!! settings()->footer_text !!}</div>

    <div class="mfs-auto d-md-down-none">&nbsp;<a href="https://official-gtds.com/" target="_blank">&nbsp;</a>
    </div>



    <div class="footer-right">{{-- v{{ \App\Libraries\MyString::version(config('site.version')) }} --}}
        <div class="form-inline mb-2"><div class="col-xs-3 mr-1"> <span class="mb-2" style="font-weight: 400"> Powered by <span class="font-semibold"> | HOKKIE <br>  </span></span>
    </div>
    <div class="col-xs-3">
        <img src="{{ asset('images/gtds.svg') }}" class="img" style="width: 40px !important;">
    </div>
</div>
</div>
</footer>
@endif


<!-- Password Modal -->
<div id="passwordModal" style="display: none; position: fixed; z-index: 9999; background: rgba(0,0,0,0.6); top: 0; left: 0; width: 100%; height: 100%;">
  <div style="background: white; width: 300px; margin: 15% auto; padding: 20px; border-radius: 5px; position: relative;">
    <h5>Enter Password</h5>
    <input type="password" id="sidebarPasswordInput" class="form-control mb-3" placeholder="Password" />
    <div class="text-right">
      <button onclick="verifyPassword()" class="btn btn-primary btn-sm">Confirm</button>
      <button onclick="closePasswordModal()" class="btn btn-secondary btn-sm">Cancel</button>
    </div>
    <p id="passwordError" style="color: red; display: none; font-size: 0.9em;">Incorrect password</p>
  </div>
</div>

<!-- Password Modal -->
<div id="passwordModal2" style="display: none; position: fixed; z-index: 9999; background: rgba(0,0,0,0.6); top: 0; left: 0; width: 100%; height: 100%;">
  <div style="background: white; width: 300px; margin: 15% auto; padding: 20px; border-radius: 5px; position: relative;">
    <h5>Enter Password</h5>
    <div class="row">
        <div class="col-9">
            <input type="password" id="sidebarPasswordInput2" class="form-control" placeholder="Password">

        </div>
        <div class="col-3">
            <button type="button" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent p-0" onclick="togglePasswords()" tabindex="-1">
                <i id="eye-icon" class="bi bi-eye-fill text-secondary"></i>
            </button>
        </div>
    </div>
    <!-- <input type="password" id="sidebarPasswordInput2" class="form-control mb-3" placeholder="Password" /> -->
    <div class="text-right mt-5">
      <button onclick="verifyPassword2()" class="btn btn-primary btn-sm">Confirm</button>
      <button onclick="closePasswordModal2()" class="btn btn-secondary btn-sm">Cancel</button>
    </div>
    <p id="passwordError2" style="color: red; display: none; font-size: 0.9em;">Incorrect password</p>
  </div>
</div>


<script>
let targetUrl = '';

  function togglePasswords() {
    const input = document.getElementById("sidebarPasswordInput2");
    const icon = document.getElementById("eye-icon");

    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("bi-eye-fill");
      icon.classList.add("bi-eye-slash-fill");
    } else {
      input.type = "password";
      icon.classList.remove("bi-eye-slash-fill");
      icon.classList.add("bi-eye-fill");
    }
  }

function openPasswordModal(event, url) {
  console.log('password');
    event.preventDefault();
    targetUrl = url;
    document.getElementById('passwordModal2').style.display = 'block';
}

function closePasswordModal2() {
    document.getElementById('passwordModal2').style.display = 'none';
    document.getElementById('sidebarPasswordInput2').value = '';
    document.getElementById('passwordError2').style.display = 'none';
}

function verifyPassword2() {
    const input = document.getElementById('sidebarPasswordInput2').value;
    if (input === 'Paopao000') {
        window.location.href = targetUrl;
    } else {
        document.getElementById('passwordError2').style.display = 'block';
    }
}

function closePasswordModal() {
    document.getElementById('passwordModal').style.display = 'none';
    document.getElementById('sidebarPasswordInput').value = '';
    document.getElementById('passwordError').style.display = 'none';
}

function verifyPassword() {
    const input = document.getElementById('sidebarPasswordInput').value;
    if (input === 'password') {
        window.location.href = targetUrl;
    } else {
        document.getElementById('passwordError').style.display = 'block';
    }
}
</script>




