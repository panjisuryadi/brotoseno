<style type="text/css">
.checkmark__circle {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  stroke-width: 2;
  stroke-miterlimit: 10;
  stroke: #0c9819;
  fill: none;
  animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  display: block;
  stroke-width: 5;
  stroke: #fff;
  padding: 1px;
  stroke-miterlimit: 10;
  box-shadow: inset 0px 0px 0px #0c9819;
  animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
}

.checkmark__check {
  transform-origin: 50% 50%;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes scale {
  0%, 100% {
    transform: none;
  }
  50% {
    transform: scale3d(1.1, 1.1, 1);
  }
}
@keyframes fill {
  100% {
    box-shadow: inset 0px 0px 0px 30px #0c9819;
  }
}

</style>
<div id="sukses" class="d-none flex row py-2 px-3 relative">
<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
  <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
  <path class="absolute checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
</svg>
<div id="ResponseInput" class="text-dark px-2"></div>
</div>
<div class="py-1"></div>
