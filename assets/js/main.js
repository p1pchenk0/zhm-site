var header = document.getElementById('header');
var spacer = document.getElementById('stickySpacer');
var topBtn = document.getElementById('topBtn');
var colorBlindToggler = document.getElementById('colorBlindToggle');
var colorBlindText = document.getElementById('colorBlindText');

var headerOffset = header.offsetTop;


window.onscroll = function (event) {
  var headerHeight = header.offsetHeight;

  headerOffset = Math.max(headerOffset, header.offsetTop);

  var yOffset     = window.pageYOffset;
  var classes     = header.classList;
  var stickyClass = 'sticky';
  var action      = yOffset > headerOffset ? 'add' : 'remove';

  spacer.style.height = (yOffset > headerOffset ? headerHeight : 0) + 'px';
  classes[action](stickyClass);
}

if (document.getElementById('sideMenu')) {
  var sidebar2 = new StickySidebar('#sideMenu', {
    topSpacing: header.offsetHeight,
    containerSelector: '.side-menu-wrapper',
    minWidth: 768
  });
}

window.addEventListener('scroll', function () {
  var yOffset = window.pageYOffset;
  var classes = topBtn.classList;
  var action  = yOffset > 100 ? 'add' : 'remove';

  classes[action]('shown');
});

topBtn.onclick = function () {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

var isColorBlindActive = {
  get value() {
    return localStorage.getItem('color-blind') === 'true';
  },
  set value(val) {
    localStorage.setItem('color-blind', val);
  }
}

function applyColorBlind() {
  var action = isColorBlindActive.value ? 'add' : 'remove';

  document.documentElement.classList[action]('color-blind');

  colorBlindText.innerText = isColorBlindActive.value ? 'Звичайна версія сайту' : 'Людям із порушенням зору';

  // setTimeout(function () {
  //   sidebar2 = new StickySidebar('#sideMenu', {
  //     topSpacing: header.offsetHeight,
  //     containerSelector: '.side-menu-wrapper',
  //     minWidth: 768
  //   });
  // }, 1000);
  // setTimeout(function () { sidebar2.destroy(); }, 100);
  // setTimeout(function () { sidebar2.updateSticky() }, 300);
}

function toggleColorBlind() {
  isColorBlindActive.value = !isColorBlindActive.value;
  
  applyColorBlind();
}

colorBlindToggler.onclick = toggleColorBlind;

applyColorBlind();

// toggleColorBlind();

// var primaryMenuItems = document.querySelectorAll('.primary-menu a');
//
// primaryMenuItems.forEach(function (linkItem) {
//   linkItem.onclick = function () {
//     window.location = linkItem.href;
//   }
// });

