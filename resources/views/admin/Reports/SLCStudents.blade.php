<html dir="ltr" lang="en">
<!-- Mirrored from www.wrappixel.com/demos/admin-templates/xtreme-admin/html/ltr/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 28 Feb 2019 09:27:29 GMT -->
<script>
window.print();

</script>
<head>
  <style type="text/css">
    .swal-icon--error {
      border-color: #f27474;
      -webkit-animation: animateErrorIcon .5s;
      animation: animateErrorIcon .5s
    }

    .swal-icon--error__x-mark {
      position: relative;
      display: block;
      -webkit-animation: animateXMark .5s;
      animation: animateXMark .5s
    }

    .swal-icon--error__line {
      position: absolute;
      height: 5px;
      width: 47px;
      background-color: #f27474;
      display: block;
      top: 37px;
      border-radius: 2px
    }

    .swal-icon--error__line--left {
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
      left: 17px
    }

    .swal-icon--error__line--right {
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      right: 16px
    }

    @-webkit-keyframes animateErrorIcon {
      0% {
        -webkit-transform: rotateX(100deg);
        transform: rotateX(100deg);
        opacity: 0
      }

      to {
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
        opacity: 1
      }
    }

    @keyframes animateErrorIcon {
      0% {
        -webkit-transform: rotateX(100deg);
        transform: rotateX(100deg);
        opacity: 0
      }

      to {
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
        opacity: 1
      }
    }

    @-webkit-keyframes animateXMark {
      0% {
        -webkit-transform: scale(.4);
        transform: scale(.4);
        margin-top: 26px;
        opacity: 0
      }

      50% {
        -webkit-transform: scale(.4);
        transform: scale(.4);
        margin-top: 26px;
        opacity: 0
      }

      80% {
        -webkit-transform: scale(1.15);
        transform: scale(1.15);
        margin-top: -6px
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1);
        margin-top: 0;
        opacity: 1
      }
    }

    @keyframes animateXMark {
      0% {
        -webkit-transform: scale(.4);
        transform: scale(.4);
        margin-top: 26px;
        opacity: 0
      }

      50% {
        -webkit-transform: scale(.4);
        transform: scale(.4);
        margin-top: 26px;
        opacity: 0
      }

      80% {
        -webkit-transform: scale(1.15);
        transform: scale(1.15);
        margin-top: -6px
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1);
        margin-top: 0;
        opacity: 1
      }
    }

    .swal-icon--warning {
      border-color: #f8bb86;
      -webkit-animation: pulseWarning .75s infinite alternate;
      animation: pulseWarning .75s infinite alternate
    }

    .swal-icon--warning__body {
      width: 5px;
      height: 47px;
      top: 10px;
      border-radius: 2px;
      margin-left: -2px
    }

    .swal-icon--warning__body,
    .swal-icon--warning__dot {
      position: absolute;
      left: 50%;
      background-color: #f8bb86
    }

    .swal-icon--warning__dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      margin-left: -4px;
      bottom: -11px
    }

    @-webkit-keyframes pulseWarning {
      0% {
        border-color: #f8d486
      }

      to {
        border-color: #f8bb86
      }
    }

    @keyframes pulseWarning {
      0% {
        border-color: #f8d486
      }

      to {
        border-color: #f8bb86
      }
    }

    .swal-icon--success {
      border-color: #a5dc86
    }

    .swal-icon--success:after,
    .swal-icon--success:before {
      content: "";
      border-radius: 50%;
      position: absolute;
      width: 60px;
      height: 120px;
      background: #fff;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg)
    }

    .swal-icon--success:before {
      border-radius: 120px 0 0 120px;
      top: -7px;
      left: -33px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-transform-origin: 60px 60px;
      transform-origin: 60px 60px
    }

    .swal-icon--success:after {
      border-radius: 0 120px 120px 0;
      top: -11px;
      left: 30px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-transform-origin: 0 60px;
      transform-origin: 0 60px;
      -webkit-animation: rotatePlaceholder 4.25s ease-in;
      animation: rotatePlaceholder 4.25s ease-in
    }

    .swal-icon--success__ring {
      width: 80px;
      height: 80px;
      border: 4px solid hsla(98, 55%, 69%, .2);
      border-radius: 50%;
      box-sizing: content-box;
      position: absolute;
      left: -4px;
      top: -4px;
      z-index: 2
    }

    .swal-icon--success__hide-corners {
      width: 5px;
      height: 90px;
      background-color: #fff;
      padding: 1px;
      position: absolute;
      left: 28px;
      top: 8px;
      z-index: 1;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg)
    }

    .swal-icon--success__line {
      height: 5px;
      background-color: #a5dc86;
      display: block;
      border-radius: 2px;
      position: absolute;
      z-index: 2
    }

    .swal-icon--success__line--tip {
      width: 25px;
      left: 14px;
      top: 46px;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
      -webkit-animation: animateSuccessTip .75s;
      animation: animateSuccessTip .75s
    }

    .swal-icon--success__line--long {
      width: 47px;
      right: 8px;
      top: 38px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-animation: animateSuccessLong .75s;
      animation: animateSuccessLong .75s
    }

    @-webkit-keyframes rotatePlaceholder {
      0% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg)
      }

      5% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg)
      }

      12% {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg)
      }

      to {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg)
      }
    }

    @keyframes rotatePlaceholder {
      0% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg)
      }

      5% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg)
      }

      12% {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg)
      }

      to {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg)
      }
    }

    @-webkit-keyframes animateSuccessTip {
      0% {
        width: 0;
        left: 1px;
        top: 19px
      }

      54% {
        width: 0;
        left: 1px;
        top: 19px
      }

      70% {
        width: 50px;
        left: -8px;
        top: 37px
      }

      84% {
        width: 17px;
        left: 21px;
        top: 48px
      }

      to {
        width: 25px;
        left: 14px;
        top: 45px
      }
    }

    @keyframes animateSuccessTip {
      0% {
        width: 0;
        left: 1px;
        top: 19px
      }

      54% {
        width: 0;
        left: 1px;
        top: 19px
      }

      70% {
        width: 50px;
        left: -8px;
        top: 37px
      }

      84% {
        width: 17px;
        left: 21px;
        top: 48px
      }

      to {
        width: 25px;
        left: 14px;
        top: 45px
      }
    }

    @-webkit-keyframes animateSuccessLong {
      0% {
        width: 0;
        right: 46px;
        top: 54px
      }

      65% {
        width: 0;
        right: 46px;
        top: 54px
      }

      84% {
        width: 55px;
        right: 0;
        top: 35px
      }

      to {
        width: 47px;
        right: 8px;
        top: 38px
      }
    }

    @keyframes animateSuccessLong {
      0% {
        width: 0;
        right: 46px;
        top: 54px
      }

      65% {
        width: 0;
        right: 46px;
        top: 54px
      }

      84% {
        width: 55px;
        right: 0;
        top: 35px
      }

      to {
        width: 47px;
        right: 8px;
        top: 38px
      }
    }

    .swal-icon--info {
      border-color: #c9dae1
    }

    .swal-icon--info:before {
      width: 5px;
      height: 29px;
      bottom: 17px;
      border-radius: 2px;
      margin-left: -2px
    }

    .swal-icon--info:after,
    .swal-icon--info:before {
      content: "";
      position: absolute;
      left: 50%;
      background-color: #c9dae1
    }

    .swal-icon--info:after {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      margin-left: -3px;
      top: 19px
    }

    .swal-icon {
      width: 80px;
      height: 80px;
      border-width: 4px;
      border-style: solid;
      border-radius: 50%;
      padding: 0;
      position: relative;
      box-sizing: content-box;
      margin: 20px auto
    }

    .swal-icon:first-child {
      margin-top: 32px
    }

    .swal-icon--custom {
      width: auto;
      height: auto;
      max-width: 100%;
      border: none;
      border-radius: 0
    }

    .swal-icon img {
      max-width: 100%;
      max-height: 100%
    }

    .swal-title {
      color: rgba(0, 0, 0, .65);
      font-weight: 600;
      text-transform: none;
      position: relative;
      display: block;
      padding: 13px 16px;
      font-size: 27px;
      line-height: normal;
      text-align: center;
      margin-bottom: 0
    }

    .swal-title:first-child {
      margin-top: 26px
    }

    .swal-title:not(:first-child) {
      padding-bottom: 0
    }

    .swal-title:not(:last-child) {
      margin-bottom: 13px
    }

    .swal-text {
      font-size: 16px;
      position: relative;
      float: none;
      line-height: normal;
      vertical-align: top;
      text-align: left;
      display: inline-block;
      margin: 0;
      padding: 0 10px;
      font-weight: 400;
      color: rgba(0, 0, 0, .64);
      max-width: calc(100% - 20px);
      overflow-wrap: break-word;
      box-sizing: border-box
    }

    .swal-text:first-child {
      margin-top: 45px
    }

    .swal-text:last-child {
      margin-bottom: 45px
    }

    .swal-footer {
      text-align: right;
      padding-top: 13px;
      margin-top: 13px;
      padding: 13px 16px;
      border-radius: inherit;
      border-top-left-radius: 0;
      border-top-right-radius: 0
    }

    .swal-button-container {
      margin: 5px;
      display: inline-block;
      position: relative
    }

    .swal-button {
      background-color: #7cd1f9;
      color: #fff;
      border: none;
      box-shadow: none;
      border-radius: 5px;
      font-weight: 600;
      font-size: 14px;
      padding: 10px 24px;
      margin: 0;
      cursor: pointer
    }

    .swal-button:not([disabled]):hover {
      background-color: #78cbf2
    }

    .swal-button:active {
      background-color: #70bce0
    }

    .swal-button:focus {
      outline: none;
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(43, 114, 165, .29)
    }

    .swal-button[disabled] {
      opacity: .5;
      cursor: default
    }

    .swal-button::-moz-focus-inner {
      border: 0
    }

    .swal-button--cancel {
      color: #555;
      background-color: #efefef
    }

    .swal-button--cancel:not([disabled]):hover {
      background-color: #e8e8e8
    }

    .swal-button--cancel:active {
      background-color: #d7d7d7
    }

    .swal-button--cancel:focus {
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(116, 136, 150, .29)
    }

    .swal-button--danger {
      background-color: #e64942
    }

    .swal-button--danger:not([disabled]):hover {
      background-color: #df4740
    }

    .swal-button--danger:active {
      background-color: #cf423b
    }

    .swal-button--danger:focus {
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(165, 43, 43, .29)
    }

    .swal-content {
      padding: 0 20px;
      margin-top: 20px;
      font-size: medium
    }

    .swal-content:last-child {
      margin-bottom: 20px
    }

    .swal-content__input,
    .swal-content__textarea {
      -webkit-appearance: none;
      background-color: #fff;
      border: none;
      font-size: 14px;
      display: block;
      box-sizing: border-box;
      width: 100%;
      border: 1px solid rgba(0, 0, 0, .14);
      padding: 10px 13px;
      border-radius: 2px;
      transition: border-color .2s
    }

    .swal-content__input:focus,
    .swal-content__textarea:focus {
      outline: none;
      border-color: #6db8ff
    }

    .swal-content__textarea {
      resize: vertical
    }

    .swal-button--loading {
      color: transparent
    }

    .swal-button--loading~.swal-button__loader {
      opacity: 1
    }

    .swal-button__loader {
      position: absolute;
      height: auto;
      width: 43px;
      z-index: 2;
      left: 50%;
      top: 50%;
      -webkit-transform: translateX(-50%) translateY(-50%);
      transform: translateX(-50%) translateY(-50%);
      text-align: center;
      pointer-events: none;
      opacity: 0
    }

    .swal-button__loader div {
      display: inline-block;
      float: none;
      vertical-align: baseline;
      width: 9px;
      height: 9px;
      padding: 0;
      border: none;
      margin: 2px;
      opacity: .4;
      border-radius: 7px;
      background-color: hsla(0, 0%, 100%, .9);
      transition: background .2s;
      -webkit-animation: swal-loading-anim 1s infinite;
      animation: swal-loading-anim 1s infinite
    }

    .swal-button__loader div:nth-child(3n+2) {
      -webkit-animation-delay: .15s;
      animation-delay: .15s
    }

    .swal-button__loader div:nth-child(3n+3) {
      -webkit-animation-delay: .3s;
      animation-delay: .3s
    }

    @-webkit-keyframes swal-loading-anim {
      0% {
        opacity: .4
      }

      20% {
        opacity: .4
      }

      50% {
        opacity: 1
      }

      to {
        opacity: .4
      }
    }

    @keyframes swal-loading-anim {
      0% {
        opacity: .4
      }

      20% {
        opacity: .4
      }

      50% {
        opacity: 1
      }

      to {
        opacity: .4
      }
    }

    .swal-overlay {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 0;
      overflow-y: auto;
      background-color: rgba(0, 0, 0, .4);
      z-index: 10000;
      pointer-events: none;
      opacity: 0;
      transition: opacity .3s
    }

    .swal-overlay:before {
      content: " ";
      display: inline-block;
      vertical-align: middle;
      height: 100%
    }

    .swal-overlay--show-modal {
      opacity: 1;
      pointer-events: auto
    }

    .swal-overlay--show-modal .swal-modal {
      opacity: 1;
      pointer-events: auto;
      box-sizing: border-box;
      -webkit-animation: showSweetAlert .3s;
      animation: showSweetAlert .3s;
      will-change: transform
    }

    .swal-modal {
      width: 478px;
      opacity: 0;
      pointer-events: none;
      background-color: #fff;
      text-align: center;
      border-radius: 5px;
      position: static;
      margin: 20px auto;
      display: inline-block;
      vertical-align: middle;
      -webkit-transform: scale(1);
      transform: scale(1);
      -webkit-transform-origin: 50% 50%;
      transform-origin: 50% 50%;
      z-index: 10001;
      transition: opacity .2s, -webkit-transform .3s;
      transition: transform .3s, opacity .2s;
      transition: transform .3s, opacity .2s, -webkit-transform .3s
    }

    @media (max-width:500px) {
      .swal-modal {
        width: calc(100% - 20px)
      }
    }

    @-webkit-keyframes showSweetAlert {
      0% {
        -webkit-transform: scale(1);
        transform: scale(1)
      }

      1% {
        -webkit-transform: scale(.5);
        transform: scale(.5)
      }

      45% {
        -webkit-transform: scale(1.05);
        transform: scale(1.05)
      }

      80% {
        -webkit-transform: scale(.95);
        transform: scale(.95)
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1)
      }
    }

    @keyframes showSweetAlert {
      0% {
        -webkit-transform: scale(1);
        transform: scale(1)
      }

      1% {
        -webkit-transform: scale(.5);
        transform: scale(.5)
      }

      45% {
        -webkit-transform: scale(1.05);
        transform: scale(1.05)
      }

      80% {
        -webkit-transform: scale(.95);
        transform: scale(.95)
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1)
      }
    }
  </style>
  <style type="text/css">
    .swal-icon--error {
      border-color: #f27474;
      -webkit-animation: animateErrorIcon .5s;
      animation: animateErrorIcon .5s
    }

    .swal-icon--error__x-mark {
      position: relative;
      display: block;
      -webkit-animation: animateXMark .5s;
      animation: animateXMark .5s
    }

    .swal-icon--error__line {
      position: absolute;
      height: 5px;
      width: 47px;
      background-color: #f27474;
      display: block;
      top: 37px;
      border-radius: 2px
    }

    .swal-icon--error__line--left {
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
      left: 17px
    }

    .swal-icon--error__line--right {
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      right: 16px
    }

    @-webkit-keyframes animateErrorIcon {
      0% {
        -webkit-transform: rotateX(100deg);
        transform: rotateX(100deg);
        opacity: 0
      }

      to {
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
        opacity: 1
      }
    }

    @keyframes animateErrorIcon {
      0% {
        -webkit-transform: rotateX(100deg);
        transform: rotateX(100deg);
        opacity: 0
      }

      to {
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
        opacity: 1
      }
    }

    @-webkit-keyframes animateXMark {
      0% {
        -webkit-transform: scale(.4);
        transform: scale(.4);
        margin-top: 26px;
        opacity: 0
      }

      50% {
        -webkit-transform: scale(.4);
        transform: scale(.4);
        margin-top: 26px;
        opacity: 0
      }

      80% {
        -webkit-transform: scale(1.15);
        transform: scale(1.15);
        margin-top: -6px
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1);
        margin-top: 0;
        opacity: 1
      }
    }

    @keyframes animateXMark {
      0% {
        -webkit-transform: scale(.4);
        transform: scale(.4);
        margin-top: 26px;
        opacity: 0
      }

      50% {
        -webkit-transform: scale(.4);
        transform: scale(.4);
        margin-top: 26px;
        opacity: 0
      }

      80% {
        -webkit-transform: scale(1.15);
        transform: scale(1.15);
        margin-top: -6px
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1);
        margin-top: 0;
        opacity: 1
      }
    }

    .swal-icon--warning {
      border-color: #f8bb86;
      -webkit-animation: pulseWarning .75s infinite alternate;
      animation: pulseWarning .75s infinite alternate
    }

    .swal-icon--warning__body {
      width: 5px;
      height: 47px;
      top: 10px;
      border-radius: 2px;
      margin-left: -2px
    }

    .swal-icon--warning__body,
    .swal-icon--warning__dot {
      position: absolute;
      left: 50%;
      background-color: #f8bb86
    }

    .swal-icon--warning__dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      margin-left: -4px;
      bottom: -11px
    }

    @-webkit-keyframes pulseWarning {
      0% {
        border-color: #f8d486
      }

      to {
        border-color: #f8bb86
      }
    }

    @keyframes pulseWarning {
      0% {
        border-color: #f8d486
      }

      to {
        border-color: #f8bb86
      }
    }

    .swal-icon--success {
      border-color: #a5dc86
    }

    .swal-icon--success:after,
    .swal-icon--success:before {
      content: "";
      border-radius: 50%;
      position: absolute;
      width: 60px;
      height: 120px;
      background: #fff;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg)
    }

    .swal-icon--success:before {
      border-radius: 120px 0 0 120px;
      top: -7px;
      left: -33px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-transform-origin: 60px 60px;
      transform-origin: 60px 60px
    }

    .swal-icon--success:after {
      border-radius: 0 120px 120px 0;
      top: -11px;
      left: 30px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-transform-origin: 0 60px;
      transform-origin: 0 60px;
      -webkit-animation: rotatePlaceholder 4.25s ease-in;
      animation: rotatePlaceholder 4.25s ease-in
    }

    .swal-icon--success__ring {
      width: 80px;
      height: 80px;
      border: 4px solid hsla(98, 55%, 69%, .2);
      border-radius: 50%;
      box-sizing: content-box;
      position: absolute;
      left: -4px;
      top: -4px;
      z-index: 2
    }

    .swal-icon--success__hide-corners {
      width: 5px;
      height: 90px;
      background-color: #fff;
      padding: 1px;
      position: absolute;
      left: 28px;
      top: 8px;
      z-index: 1;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg)
    }

    .swal-icon--success__line {
      height: 5px;
      background-color: #a5dc86;
      display: block;
      border-radius: 2px;
      position: absolute;
      z-index: 2
    }

    .swal-icon--success__line--tip {
      width: 25px;
      left: 14px;
      top: 46px;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
      -webkit-animation: animateSuccessTip .75s;
      animation: animateSuccessTip .75s
    }

    .swal-icon--success__line--long {
      width: 47px;
      right: 8px;
      top: 38px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-animation: animateSuccessLong .75s;
      animation: animateSuccessLong .75s
    }

    @-webkit-keyframes rotatePlaceholder {
      0% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg)
      }

      5% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg)
      }

      12% {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg)
      }

      to {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg)
      }
    }

    @keyframes rotatePlaceholder {
      0% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg)
      }

      5% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg)
      }

      12% {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg)
      }

      to {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg)
      }
    }

    @-webkit-keyframes animateSuccessTip {
      0% {
        width: 0;
        left: 1px;
        top: 19px
      }

      54% {
        width: 0;
        left: 1px;
        top: 19px
      }

      70% {
        width: 50px;
        left: -8px;
        top: 37px
      }

      84% {
        width: 17px;
        left: 21px;
        top: 48px
      }

      to {
        width: 25px;
        left: 14px;
        top: 45px
      }
    }

    @keyframes animateSuccessTip {
      0% {
        width: 0;
        left: 1px;
        top: 19px
      }

      54% {
        width: 0;
        left: 1px;
        top: 19px
      }

      70% {
        width: 50px;
        left: -8px;
        top: 37px
      }

      84% {
        width: 17px;
        left: 21px;
        top: 48px
      }

      to {
        width: 25px;
        left: 14px;
        top: 45px
      }
    }

    @-webkit-keyframes animateSuccessLong {
      0% {
        width: 0;
        right: 46px;
        top: 54px
      }

      65% {
        width: 0;
        right: 46px;
        top: 54px
      }

      84% {
        width: 55px;
        right: 0;
        top: 35px
      }

      to {
        width: 47px;
        right: 8px;
        top: 38px
      }
    }

    @keyframes animateSuccessLong {
      0% {
        width: 0;
        right: 46px;
        top: 54px
      }

      65% {
        width: 0;
        right: 46px;
        top: 54px
      }

      84% {
        width: 55px;
        right: 0;
        top: 35px
      }

      to {
        width: 47px;
        right: 8px;
        top: 38px
      }
    }

    .swal-icon--info {
      border-color: #c9dae1
    }

    .swal-icon--info:before {
      width: 5px;
      height: 29px;
      bottom: 17px;
      border-radius: 2px;
      margin-left: -2px
    }

    .swal-icon--info:after,
    .swal-icon--info:before {
      content: "";
      position: absolute;
      left: 50%;
      background-color: #c9dae1
    }

    .swal-icon--info:after {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      margin-left: -3px;
      top: 19px
    }

    .swal-icon {
      width: 80px;
      height: 80px;
      border-width: 4px;
      border-style: solid;
      border-radius: 50%;
      padding: 0;
      position: relative;
      box-sizing: content-box;
      margin: 20px auto
    }

    .swal-icon:first-child {
      margin-top: 32px
    }

    .swal-icon--custom {
      width: auto;
      height: auto;
      max-width: 100%;
      border: none;
      border-radius: 0
    }

    .swal-icon img {
      max-width: 100%;
      max-height: 100%
    }

    .swal-title {
      color: rgba(0, 0, 0, .65);
      font-weight: 600;
      text-transform: none;
      position: relative;
      display: block;
      padding: 13px 16px;
      font-size: 27px;
      line-height: normal;
      text-align: center;
      margin-bottom: 0
    }

    .swal-title:first-child {
      margin-top: 26px
    }

    .swal-title:not(:first-child) {
      padding-bottom: 0
    }

    .swal-title:not(:last-child) {
      margin-bottom: 13px
    }

    .swal-text {
      font-size: 16px;
      position: relative;
      float: none;
      line-height: normal;
      vertical-align: top;
      text-align: left;
      display: inline-block;
      margin: 0;
      padding: 0 10px;
      font-weight: 400;
      color: rgba(0, 0, 0, .64);
      max-width: calc(100% - 20px);
      overflow-wrap: break-word;
      box-sizing: border-box
    }

    .swal-text:first-child {
      margin-top: 45px
    }

    .swal-text:last-child {
      margin-bottom: 45px
    }

    .swal-footer {
      text-align: right;
      padding-top: 13px;
      margin-top: 13px;
      padding: 13px 16px;
      border-radius: inherit;
      border-top-left-radius: 0;
      border-top-right-radius: 0
    }

    .swal-button-container {
      margin: 5px;
      display: inline-block;
      position: relative
    }

    .swal-button {
      background-color: #7cd1f9;
      color: #fff;
      border: none;
      box-shadow: none;
      border-radius: 5px;
      font-weight: 600;
      font-size: 14px;
      padding: 10px 24px;
      margin: 0;
      cursor: pointer
    }

    .swal-button:not([disabled]):hover {
      background-color: #78cbf2
    }

    .swal-button:active {
      background-color: #70bce0
    }

    .swal-button:focus {
      outline: none;
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(43, 114, 165, .29)
    }

    .swal-button[disabled] {
      opacity: .5;
      cursor: default
    }

    .swal-button::-moz-focus-inner {
      border: 0
    }

    .swal-button--cancel {
      color: #555;
      background-color: #efefef
    }

    .swal-button--cancel:not([disabled]):hover {
      background-color: #e8e8e8
    }

    .swal-button--cancel:active {
      background-color: #d7d7d7
    }

    .swal-button--cancel:focus {
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(116, 136, 150, .29)
    }

    .swal-button--danger {
      background-color: #e64942
    }

    .swal-button--danger:not([disabled]):hover {
      background-color: #df4740
    }

    .swal-button--danger:active {
      background-color: #cf423b
    }

    .swal-button--danger:focus {
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(165, 43, 43, .29)
    }

    .swal-content {
      padding: 0 20px;
      margin-top: 20px;
      font-size: medium
    }

    .swal-content:last-child {
      margin-bottom: 20px
    }

    .swal-content__input,
    .swal-content__textarea {
      -webkit-appearance: none;
      background-color: #fff;
      border: none;
      font-size: 14px;
      display: block;
      box-sizing: border-box;
      width: 100%;
      border: 1px solid rgba(0, 0, 0, .14);
      padding: 10px 13px;
      border-radius: 2px;
      transition: border-color .2s
    }

    .swal-content__input:focus,
    .swal-content__textarea:focus {
      outline: none;
      border-color: #6db8ff
    }

    .swal-content__textarea {
      resize: vertical
    }

    .swal-button--loading {
      color: transparent
    }

    .swal-button--loading~.swal-button__loader {
      opacity: 1
    }

    .swal-button__loader {
      position: absolute;
      height: auto;
      width: 43px;
      z-index: 2;
      left: 50%;
      top: 50%;
      -webkit-transform: translateX(-50%) translateY(-50%);
      transform: translateX(-50%) translateY(-50%);
      text-align: center;
      pointer-events: none;
      opacity: 0
    }

    .swal-button__loader div {
      display: inline-block;
      float: none;
      vertical-align: baseline;
      width: 9px;
      height: 9px;
      padding: 0;
      border: none;
      margin: 2px;
      opacity: .4;
      border-radius: 7px;
      background-color: hsla(0, 0%, 100%, .9);
      transition: background .2s;
      -webkit-animation: swal-loading-anim 1s infinite;
      animation: swal-loading-anim 1s infinite
    }

    .swal-button__loader div:nth-child(3n+2) {
      -webkit-animation-delay: .15s;
      animation-delay: .15s
    }

    .swal-button__loader div:nth-child(3n+3) {
      -webkit-animation-delay: .3s;
      animation-delay: .3s
    }

    @-webkit-keyframes swal-loading-anim {
      0% {
        opacity: .4
      }

      20% {
        opacity: .4
      }

      50% {
        opacity: 1
      }

      to {
        opacity: .4
      }
    }

    @keyframes swal-loading-anim {
      0% {
        opacity: .4
      }

      20% {
        opacity: .4
      }

      50% {
        opacity: 1
      }

      to {
        opacity: .4
      }
    }

    .swal-overlay {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 0;
      overflow-y: auto;
      background-color: rgba(0, 0, 0, .4);
      z-index: 10000;
      pointer-events: none;
      opacity: 0;
      transition: opacity .3s
    }

    .swal-overlay:before {
      content: " ";
      display: inline-block;
      vertical-align: middle;
      height: 100%
    }

    .swal-overlay--show-modal {
      opacity: 1;
      pointer-events: auto
    }

    .swal-overlay--show-modal .swal-modal {
      opacity: 1;
      pointer-events: auto;
      box-sizing: border-box;
      -webkit-animation: showSweetAlert .3s;
      animation: showSweetAlert .3s;
      will-change: transform
    }

    .swal-modal {
      width: 478px;
      opacity: 0;
      pointer-events: none;
      background-color: #fff;
      text-align: center;
      border-radius: 5px;
      position: static;
      margin: 20px auto;
      display: inline-block;
      vertical-align: middle;
      -webkit-transform: scale(1);
      transform: scale(1);
      -webkit-transform-origin: 50% 50%;
      transform-origin: 50% 50%;
      z-index: 10001;
      transition: opacity .2s, -webkit-transform .3s;
      transition: transform .3s, opacity .2s;
      transition: transform .3s, opacity .2s, -webkit-transform .3s
    }

    @media (max-width:500px) {
      .swal-modal {
        width: calc(100% - 20px)
      }
    }

    @-webkit-keyframes showSweetAlert {
      0% {
        -webkit-transform: scale(1);
        transform: scale(1)
      }

      1% {
        -webkit-transform: scale(.5);
        transform: scale(.5)
      }

      45% {
        -webkit-transform: scale(1.05);
        transform: scale(1.05)
      }

      80% {
        -webkit-transform: scale(.95);
        transform: scale(.95)
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1)
      }
    }

    @keyframes showSweetAlert {
      0% {
        -webkit-transform: scale(1);
        transform: scale(1)
      }

      1% {
        -webkit-transform: scale(.5);
        transform: scale(.5)
      }

      45% {
        -webkit-transform: scale(1.05);
        transform: scale(1.05)
      }

      80% {
        -webkit-transform: scale(.95);
        transform: scale(.95)
      }

      to {
        -webkit-transform: scale(1);
        transform: scale(1)
      }
    }
  </style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon icon -->

  <title>Examination Reports</title>
  <!-- Custom CSS -->

  <!-- Custom CSS -->

  <style>
    td.details-control {
      background: url('dist/js/pages/datatable/details_open.png') no-repeat center center;
      cursor: pointer;
    }

    tr.shown td.details-control {
      background: url('dist/js/pages/datatable/details_close.png') no-repeat center center;
    }
  </style>
  <link href="{{ asset('userbackend/plugins/peshawarmodel_style.css') }}" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->


  <style type="text/css">
    /* Chart.js */
    @-webkit-keyframes chartjs-render-animation {
      from {
        opacity: 0.99
      }

      to {
        opacity: 1
      }
    }

    @keyframes chartjs-render-animation {
      from {
        opacity: 0.99
      }

      to {
        opacity: 1
      }
    }

    .chartjs-render-monitor {
      -webkit-animation: chartjs-render-animation 0.001s;
      animation: chartjs-render-animation 0.001s;
    }
  </style>
  <style type="text/css">
    .jqstooltip {
      position: absolute;
      left: 0px;
      top: 0px;
      visibility: hidden;
      background: rgb(0, 0, 0) transparent;
      background-color: rgba(0, 0, 0, 0.6);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
      -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
      color: white;
      font: 10px arial, san serif;
      text-align: left;
      white-space: nowrap;
      padding: 5px;
      border: 1px solid white;
      z-index: 10000;
    }

    .jqsfield {
      color: white;
      font: 10px arial, san serif;
      text-align: left;
    }
  </style>
</head>

<body cz-shortcut-listen="true">
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader" style="display: none;">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
    </div>
  </div>

  <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="overlay"
    data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

    <style type="text/css">
      #idd {
        border: 1px solid;
        font-weight: bold;
        padding: 1px;
        text-align: center;

      }

      .scrl {
        width: 100% !important;
        overflow: scroll;
      }

      @page {
        size: A4;
        margin: 0;
      }

      @media print {



        footer {
          display: none;
        }

        body {
          font-size: 12px !important;
          padding: 0px;
        }

        .hello {
          border: 1px solid;
          font-weight: bold;

          text-align: center;
          padding-left: 5px;
          padding-right: 5px;


        }

        .scrl {
          width: 80% !important;
          overflow: hidden;
        }

        .btn {
          display: none;
        }

        .hideWhilePrinting {
          display: none;
          margin: 0 0 0;
        }

        p,
        h3 {
          margin: 0 0 0;
        }

        .row {
          margin-top: -14px;
        }
        .card {
          padding: 1px;
          padding-left: 0;
          padding-right: 0;
        }
        .pagebreak {
          clear: both;
          page-break-after: always;
        }
        .table,
        .table-bordered,
        .table-hover {
          width: 10%;
          margin-top: 6px;
        }
        .table1,
        .table-bordered,
        .table-hover {
          margin-left: 83%;
          margin-top: -280px;
        }
        .table>thead>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>th,
        .table>tbody>tr>td {
          padding: 2px !important;
          border: 1px solid #000000 !important;
          font-size: 10pt;
        }

        div {
          font-size: 10pt;
        }
        .printableArea{
          margin-top: 30px;
        }
      }
    </style>


    <!-- ============================================================== -->
    <div class="page-wrapper" style="display: block;">
      <div class="container-fluid scrl">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
          <div class="col-12">
            <!-- ========================================================================================== -->
            <!--                                      Basic select2                                         -->
            <!-- ========================================================================================== -->
            <div class="card">
              <div class="card-body">
                <div>
                  <div class="col-md-12" style="font-weight: bold">
                    <div class="card card-body printableArea pagebreak">
                      <!--   <img src="dmclogo.jpg" height="100" width="100"> -->
                      <?php

                                //    dd($request->pw);
                    

                                                // $stdid = $r->studentid;
                                                // $academicasession = $r->asession;
                                                // $academicterm = $r->term;
                                                // $termname = \App\Models\TermName::where('campusid', Auth::user()->campusid)->where('id', $academicterm)->value('termname');
                                                // dd($termname);
                                                // $studentclass = $r->class;
                                             
                                                if(empty($students[0]->studentid)){
                                                    dd("No SLC Found Aganist Student ");
                                                }
                                                $stdid=$students[0]->studentid;
                                                $campusid = Auth::user()->campusid;
                       $campus = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
                       $slccheck =DB::select("select * from schooleavingcirtificates where campusid = ? and studentid=? 
                       and type='Slc'
                       
                       ",[$campusid,$stdid]);
                       if(empty($slccheck)){
                        return abort(404);
                                                }
                                            ?>
                      <h2><b></b> <span class="pull-right">
                          <center>{{ $campus->CampusName }}</center>
                      <h3><b></b> <span class="pull-right">
                          <center>{{ $campus->DefaultAddress }}</center>
                      <h5><b></b> <span class="pull-right">
                          <center>{{ $campus->Phone }}</center>
                          <br>
                          <center> <?php echo  $request->copy; ?> Copy</center>
                        </span></h5>
                        <br>
                      <div class="row">
                        <div class="col-sm-1">
                          <center>No.</center>
                        </div>
                        <div class="col-sm-1">
                        </div>
                        <div class="col-sm-2">
                          <input type="text" class="form-control" >
                        </div>
                        <div class="col-sm-4">
                          <center><img src="{{ asset('campusLogos/' . $campus->Logo_photo_path )}}"
                              style="height: 150px" class="img-responsive">
                          </center>

                        </div>
                        <div class="col-sm-2">
                          <center>Adm. No.</center>
                        </div>
                        <div class="col-sm-2">
                          <input type="readonly" value="{{ $students[0]->studentid }}"   class="form-control" >
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-1">
                        </div>
                        <div class="col-sm-10">
                          <center>
                            <h3>SCHOOL LEAVING CERTIFICATE</h3>
                          </center>
                        </div>
                        <div class="col-sm-1">
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-6">1. Name of the Pupil</div>
                        <div class="col-sm-6">
                            <input type="readonly"  disabled value="{{ $students[0]->studentname }}"  class="form-control" ></div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-6">2. Father's Name</div>
                        <div class="col-sm-6">
                            <input type="readonly" disabled value="{{ $students[0]->fathername }}" class="form-control" ></div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-6">3. Address</div>
                        <div class="col-sm-6">
              <input type="readonly"  disabled value="{{ $students[0]->address1 }}" class="form-control" ></div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-6">4. Date of Birth (in figure)</div>
                        <div class="col-sm-6">
                        <input type="readonly" disabled value="{{ $students[0]->dob }}" class="form-control" ></div>
                      </div>
                      <div class="row" style="display: none;">
                        <div class="col-sm-6">5. Religion</div>
                        <div class="col-sm-6"><input type="readonly"
                            disabled   value="{{ $students[0]->date }}" class="form-control" ></div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-6">6. Date of admission</div>
                        <div class="col-sm-6"><input type="text" disabled   value="{{ $students[0]->date }}" class="form-control" ></div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-6">7. Class at time of leaving</div>
                        <div class="col-sm-6">
                            <input type="text" disabled   value="{{ $students[0]->ClassName }}" class="form-control" ></div>
                      </div>
                      <br>
                      <div class="row">
                          {{-- $request->Conduct --}}
                        <div class="col-sm-6">8. Attendance in the Present class</div>
                        <div class="col-sm-6">
                            <input type="text" disabled   value="<?php  echo $request->pd."  out  ".$request->tw ?>" class="form-control" ></div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-6">9. Conduct</div>
                        <div class="col-sm-6"><input type="text" disabled   value="{{ $request->Conduct }}" class="form-control" ></div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-6">10. Reasons for leaving</div>
                        <div class="col-sm-6"><input type="text" disabled   value="{{ $request->reason }}"  class="form-control" ></div>
                      </div>
                      <br>
                      <div class="row">
                          <?php
                                    $campusid = Auth::user()->campusid;
                                    $stdid = $students[0]->studentid;
                                    // dd($session);
                                    $students = DB::select("
                                    SELECT max(date_add(makedate(f.year, f.month), interval (f.month)-1 month)) as mm FROM feegenerations f
                                    where campusid = ? and studentid=? and ispaid=1
                                    ", [$campusid,$stdid]);
                                      $date=$students[0]->mm;
                            ?>
                        <div class="col-sm-6">11. Dues paid upto the month of</div>
                        <div class="col-sm-6"><input type="readonly" disabled value="<?php echo  date('Y', strtotime($date)); ?>"class="form-control" ></div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-6">12. Remarks</div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <textarea class="form-control" id="exampleFormControlTextarea3" rows="3"></textarea>
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-12">
                          <p><center>Certified that the above information is in accordance with the school records</center></p>
                        </div>
                      </div>
                      <br>
                      <br>

                      <div class="row">
                        <div class="col-sm-6">
                          <p>Date of Issue:    <?php  echo Date('d-m-Y')?></p>
                        </div>
                        <div class="col-sm-4">
                        </div>

                        <div class="col-sm-2">
                          <p><u><b>PRINCIPAL</b></u></p>
                        </div>
                      </div>

                    </div>
                    <div class="clearfix"></div>


                  </div>
                </div>
              </div>




            </div>












            <div class="text-center">
              <button class="btn btn-primary" onclick="javascript:window.print();"><i class="fa fa-print"
                  id="print"></i>&nbsp; Print</button>
            </div>
          </div>
        </div>



      </div>
    </div>
  </div>
  </div>
  {{-- <footer class="footer text-center">
    Copyright © 2020 Peshawar Model Schools. For Queries, Complaints and Suggestions Please write to us
    queries@pmei.edu.pk
  </footer> --}}

  <script>
    $(function() {
            $("#print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $("div.printableArea").printArea(options);
            });
        });
  </script>
</body>

</html>
