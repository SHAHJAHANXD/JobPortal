'use strict';

/**
 * This will prevent the scroll went the user on mobile clicks on the burger menu
 */
function toggleMobileMenu() {
  // Lest show/hide all the elements that we need
  $('.menu__wrapHidden').toggle();
  $('.menu-burger-icon').toggle();
  $('.menu-close-icon').toggle();

  // If the device need more space to scroll
  if ($('menu__multiItem').length) {
    $('.menu__wrapHidden').height($(window).height() - 132);
  } else {
    $('.menu__wrapHidden').height($(window).height());
  }

  // If the new menu is visible we want to prevent the html to be scrollable
  if ($('.menu__wrapHidden').is(':visible')) {
    $('body, html').addClass('active-menu');
  } else {
    $('.active-menu').removeClass('active-menu');
  }
}

/**
 * General use email validator
 * @param string email
 * @returns {boolean}
 */
function verifyEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  var validate = re.test(email.trim());

  return validate;
}

/**
 * General use phone validator
 * @param string phone
 * @returns {boolean}
 */
function verifyPhone(phone) {
  var re = /^\d+$/;
  var validate = re.test(phone.trim());
  if(validate){
    if (phone.trim().length != domain.phoneLength){
      validate = false;
    }
  }
  return validate;
}


/**
 * General use password validator
 * @param string password
 * @returns {boolean}
 */

function verifyPassword(password) {

  var re = /.{6,100}/;
  var validate = re.test(password);

  return validate;
}

/**
 * Asynchronous method that receives the jobId and verifies
 * if the geocode associated with the job should be reprocessed
 * or not.
 */
//function fixGeocodeProcess(jobId, country) {
//  // Var initialization
//  var params = {};
//  //Request location
//  var where = '/ajax/fixGeocodeProcess/fixGeocodeProcess.php';
//  // Set params to send.
//  params.jobid   = jobId;
//  params.country = country;
//  // Async call
//  $.get({url: where, data: params, async: true});
//}

/**
 * Show pop up depending on the Counter sent in the parameter
 * @param elementClicked
 * @param showWhenCounter
 * @param jobId
 * @returns {boolean}
 */
function showPopUpDependingCounters(elementClicked, showWhenCounter, jobId = ""){

  if (domain.jobSeekerLogin != "1" && app.pageName == "serp" && !sessionStorage.getItem("popupViewed")) {

      // Show PopUp in Serp depending on counters
      if(getElementCounter(elementClicked) >= showWhenCounter) {
        // Set job seeker context depending on where the user clicked
        if (elementClicked == "job_search") {
          appStorage.jobSeekerContext = "accountGating_search";
        }
        
        let toReplace = new RegExp(`"${elementClicked}":${showWhenCounter}`, "g");

        // Restart Session Counter to not show PupUp Again
        sessionStorage.elemClicks= sessionStorage.elemClicks.replace(toReplace,`"${elementClicked}":${showWhenCounter - 1}`);

        // Send Job id to redirect to the whitepage
        if (jobId) appStorage.activeJobId = jobId;

        // Case for mobile and bulk context
        if (domain.device == "mobile" &&
            appStorage.bulkContext !== undefined) {
          appStorage.jobSeekerContext = "serpBulkUsersPopUpDefault";
          if (elementClicked == "job_click") {
            appStorage.jobSeekerContext = "serpBulkUsersPopUpJobClick";
          } else if (elementClicked == "job_search") {
            appStorage.jobSeekerContext = "serpBulkUsersPopUpJobSearch";
          } else if (elementClicked == "pagination") {
            appStorage.jobSeekerContext = "serpBulkUsersPopUpPagination";
          }
        }

        showJobSeekerPopup("checkEmailStep");
        return true;
      }else {
        return false;
      }
  }
}



/**
 * This will take the data-link attribute and re route the user to
 * the endpoint while also tracking the click
 * @param html elem      The  job been click on
 * @param event event     Event for firefox compatibility
 */


function openJobDescription(elem, jobId, event) {
  var isRealUserClick = event.isTrusted;

  // Save events
  if (app.pageName == 'serp') {

    let urlParams   = new URLSearchParams(location.search);
    let eventParams = {
      'event'                 : 'serp_job_card_click',
      'jobId'                 : jobId,
      'page_number'           : urlParams.has('p') ? urlParams.get('p') : '1',
      'card_position'         : elem.parent().attr('card-position'),
      'job_attribute_new_job' : $(elem).find('.card__job--new').text() != "",
      'job_attribute_promoted': $(elem).find('.card__job-sponsored').text() != "",
      'job_attribute_salary'  : $(elem).find('.card__job-badges-holder .card__job-badge-salary').text(),
      'job_attribute_apply'   : $(elem).find('.card__job-badges-holder .card__job-badge-apply').text() != "",
      'job_attribute_remote'  : $(elem).find('.card__job-badges-holder .card__job-badge-remote').text() != "",
      'job_attribute_job_type': $(elem).find('.card__job-badges-holder .card__job-badge-job-type').text(),
      'trigger'               : (!isRealUserClick) ? 'default' : ''
    }

    saveJobPreviewEvent(eventParams);
  }

  // We want to prevent the anchor to act out
  if (event.stopPropagation) {
    event.stopPropagation();
    event.preventDefault();
  }

  if (domain.jobSeekerLogin === '1') {
    var data = {};
    data.jobid = jobId;
    //deactivating this to give priority to actual open links like emails etc, this needs to be address later
    // userEventTracket('job_click', data);
  }

  // Account gating for mobile
  if (domain.jobSeekerLogin == "0" &&
      app.pageName == "serp"  &&
      isRealUserClick &&
      app.pageVersion == "v2") {
    // Clean job location
    let location = $("div[data-id=" + jobId + "] .card__job-location").text();
    location = location.split("•").pop().trim();
    addKeywordToSessionStorage(elem.attr("title"), "job_click", location, jobId);
    incrementCounterPopUp("job_click");
  }
  //Check if the job is PPC or not
  var isPPC = $(elem).attr("data-ppc");
  var isQuickApply = $(elem).attr("data-quickapply");

  // If the popUp is getting shown and the job is not PPC then don't redirect
  if (isPPC === "false" &&
      isQuickApply === "false" &&
      domain.jobSeekerLogin == "0"  &&
      getElementCounter("job_click") >= 2  &&
      app.pageName == "serp" &&
      domain.device == "mobile" &&
      isRealUserClick &&
      app.pageVersion == "v2") {

    showPopUpDependingCounters("job_click", 2, jobId);
    return false;
  }else{
    //// Call the async method to check if the geocode should be reprocessed.
    //if (app.pageName === 'serp' && domain.device === 'desktop') {
    //  fixGeocodeProcess(jobId, domain.country);
    //}

    // page jobs have an special job preview for desktop
    // all this functions are on the page-search.js file
    if (app.pageName === 'serp' && domain.device === 'desktop' &&
        (!event.metaKey && !event.ctrlKey)) {
      // Validate if the current job is already opened to not open it again
      if ($("div[data-id=" + jobId + "].card__job--preview").length === 0) {
        // // this will return the jobId form the element
        // // while also flag the element as 'preview active'
        let jobId = getPreviewJobId(elem);

        // we show the review card
        openJobPreview(jobId, 'click');

        // Make sure the job card like button matches with the preview like button
        if ($(`.card__job [data-button-id=${jobId}]`).hasClass('is-saved')) {
          $(`.card--preview [data-button-id=${jobId}]`).addClass('is-saved');
          $(`.card--preview [data-button-id=${jobId}]`).removeClass('not-saved');
        } else if($(`.card__job [data-button-id=${jobId}]`).hasClass('not-saved')) {
          $(`.card--preview [data-button-id=${jobId}]`).addClass('not-saved');
          $(`.card--preview [data-button-id=${jobId}]`).removeClass('is-saved');
        }
      }
      
      return true;
    }

    // General use link
    var link = elem.attr('data-link') + '&nb=true';

    // if it is mobile we change the current tab
    // if it is desktop we open the job in a new one
    if (domain.device === 'mobile') {
      window.location.href = link;
    } else {
      window.open(link, '_blank');
    }
  }



}

/**
 * @param elementName element to get the counter
 * @returns int
 */
function getElementCounter(elementName) {
  let startCounter = 0;

  try {
    // We try to get the element clicks in sessionStorage
    let elemClicked = $.parseJSON(sessionStorage.elemClicks);
    elemClicked = elemClicked[elementName] !== undefined ? elemClicked[elementName] : startCounter;

    return elemClicked
  } catch (err) {
    // If there aren't clicks done then return start counter
    return startCounter;
  }

}

/**
 * Set into session Storage a counter to an element
 * @param elementName element to set the counter
 */
function incrementCounterPopUp(elementName) {
    var elementsClicked = sessionStorage.elemClicks !== undefined ? $.parseJSON(sessionStorage.elemClicks) : {};
    elementsClicked[elementName] = getElementCounter(elementName) + 1;

    // Assign json to Session Storage
    sessionStorage["elemClicks"] = JSON.stringify(elementsClicked);
}

/**
 * @param keyword job keyword
 * @param context job context
 * @param location job location
 * @param jobId
 */
function addKeywordToSessionStorage(keyword, context, location = "", jobId = "") {
  // Check if the keyword has value
  if(keyword != ""){
    let events = {"job_click": {}, "job_search": {}};
    let keywords = sessionStorage["keywords"] !== undefined ? $.parseJSON(sessionStorage["keywords"]) : events;

    // Define job fields
    if(context == "job_click"){
      keywords[context][keyword] = {title: keyword, jobId: jobId, location : location, language : domain.language};
    }else{
      keywords[context][keyword] = {title: keyword, location : location,language : domain.language};
    }

    // Assign json to Session Storage
    sessionStorage["keywords"] = JSON.stringify(keywords);
  }
}

/**
 * Get Session Storage keywords
 * @returns json
 */
function getKeywordsSessionStorage(){
  return $.parseJSON(sessionStorage["keywords"] ?? "{}")
}

/**
 * @param params events to save
 */
function saveJobPreviewEvent(params) {
  var formData = new FormData();

  // Building data
  formData.append("event", params.event);
  formData.append("jobid", params.jobId);
  formData.append("country", domain.country);
  formData.append("page_number", params.page_number);
  formData.append("card_position", params.card_position);
  formData.append("trigger", params.trigger);
  formData.append("isLogginIn", !!parseInt(domain.jobSeekerLogin));
  formData.append("job_attribute_apply", params.job_attribute_apply);
  formData.append("job_attribute_salary", params.job_attribute_salary);
  formData.append("job_attribute_remote", params.job_attribute_remote);
  formData.append("job_attribute_new_job", params.job_attribute_new_job);
  formData.append("job_attribute_promoted", params.job_attribute_promoted);
  formData.append("job_attribute_job_type", params.job_attribute_job_type);

  var where = '/ajax/applyProcess/registerApplyEvents.php';

  fetch(where, {method: 'POST', body: formData}).then((response) => {response.text();})
}

/**
 * This will verify if an file input have the appropiate file type to be upload
 * and size
 * @param elem
 * @returns {boolean}
 */

function uploadJobSeekerFile(elem, successFunction) {

  //If no value then there is nothing to do
  if ($(elem).val() === '') {
    return true;
  }

  //Clean the fileName to remove the fakepath
  var fileName = $(elem).val().replace(/C:\\fakepath\\/i, '');
  //From the fileName we extract the fileType
  var fileType = fileName.split('.').pop();
  //Array with the list of type of document we currently accept
  var acceptedTypes = ['doc', 'docx', 'pdf', 'txt', 'rtf', 'odt'];
  //Attribute name of the file input (Ex: name='cv')
  var inputName = $(elem).attr('name');
  //Javascirpt native call of the input
  var input = document.getElementById(inputName);
  //File value to be upload
  var file = input.files[0];
  //Size of the file that wants to be uploaded
  var fileSize = file.size;

  //Remove any previous message or indication of errors
  $('.button--uploadFile[for=' + inputName + '].has--file').
      removeClass('has--file');
  $('.button--uploadFile[for=' + inputName + '].has--error').
      removeClass('has--error');
  $('.error-message[data-for=' + inputName + ']').removeClass('has--error');
  $('.success--file[data-for=' + inputName + ']').removeClass('has--file');

  //If it all good then we update the visuals of the input to fit the new file
  if ((jQuery.inArray(fileType, acceptedTypes) > -1) && (fileSize < 2000000)) {

    // $('.success--file[data-for=' + inputName + '] .success--file__text').
    //     text(fileName);
    // $('.success--file[data-for=' + inputName + ']').addClass('has--file');
    // $('.button--uploadFile[for=' + inputName + ']').addClass('has--file');
    $('input[name=file-' + inputName + ']').val(fileName);
    if (successFunction) {
      successFunction(file);
    }

  } else {

    //If the file is not the right type we show an error message, specifict
    //to the file type
    if (jQuery.inArray(fileType, acceptedTypes) <= -1) {
      $('.error-type[data-for=' + inputName + ']').addClass('has--error');
    }
    //If is not the right size we show an error message, specifict to the file
    // size (2MB)
    if (fileSize > 2000000) {
      $('.error-size[data-for=' + inputName + ']').addClass('has--error');
    }
    //Add the necesary class to the input to show the error red border
    $('.button--uploadFile[for=' + inputName + ']').addClass('has--error');
    //Clean the input value so we don't upload an none accepted file
    $(elem).val('');
    $('input[name=file-' + inputName + ']').val('');
  }
}

function clearFileInput(inputName) {
  $('.button--uploadFile[for=' + inputName + '].has--file').
      removeClass('has--file');
  $('input[name=cv_id]').removeAttr('value');
  $('.success--file[data-for=' + inputName + ']').removeClass('has--file');
  $('input[name=file-' + inputName + ']').val('');
  $('input[name=' + inputName + ']').val('');
}

/**
 * This will add or remove the job to the favorites table depending if
 * the job was already in the user's favorites list.
 * @param string id
 * @param event event
 */
function addToFavoritesJob(jobId, event, source) {
  if (event.stopPropagation) {
    event.stopPropagation();
    event.preventDefault();
  }

  //if they are not log in we show then the user popup
  if (domain.jobSeekerLogin === '0') {

    appStorage.jobSeekerContext = 'favorites';
    appStorage.actionSouce = source;
    appStorage.jobSeekerFavToAdd = jobId;
    showJobSeekerPopup('checkEmailStep');

  } else {
    //If the button press has the class active-fav
    // we want to remove that jobid from the favorites
    if ($(event.target).hasClass('active-fav')) {

      // We remove the active-fav class from the clicked button
      $(event.target).removeClass('active-fav');

      // some buttons need to updates the text from "remove to favorites"
      // to "add to favorites"
      $(event.target).text($(event.target).attr('data-fav'));

      // On white page we want to update all the fav call to action
      if (app.pageName == 'whitepage') {
        $('.button--favHeader, button--ctaFav').removeClass('active-fav');
        $('.button--ctaFav').text($('.button--ctaFav').attr('data-fav'));
      }

      // on serp page desktop we want to also update the favorites
      if (app.pageName == 'serp' && domain.device == 'desktop') {
        $('.card__job[data-id=' + jobId + ']').
            find('.button--fav').
            removeClass('active-fav');
        $('.button--fav[data-button-id=' + jobId + ']').
            removeClass('active-fav');
        if ($('#jobPreview').html() != '' &&
            $('.card__job[data-id=' + jobId + ']').
                hasClass('card__job--preview'))
          addToJobIdsSessionStorage(jobId, $('#jobPreview').html());
      }
      var location = '';
      if (app.pageName == 'serp') {
        location = $('#nv-l').val();
      }
      //We remove the jobid from the job_favorite history
      var data = {};
      data.jobid = jobId;
      data.searchLocation = location;
      userEventTracket('job_favorite', data, 'delete');

    } else {

      //We add the active-fav class to update visuals and flag the clicked elemt
      $(event.target).addClass('active-fav');

      // some buttons need to updates the text from "add to favorites"
      // to "remove to favorites"
      $(event.target).text($(event.target).attr('data-rem'));

      // On white page we want to update all the fav call to action
      if (app.pageName == 'whitepage') {
        $('.button--favHeader, button--ctaFav').addClass('active-fav');
        $('.button--ctaFav').text($('.button--ctaFav').attr('data-rem'));
      }

      if (app.pageName == 'serp' && domain.device == 'desktop') {
        $('.card__job[data-id=' + jobId + ']').
            find('.button--fav').
            addClass('active-fav');
        $('.button--fav[data-button-id=' + jobId + ']').addClass('active-fav');
        if ($('#jobPreview').html() != '' &&
            $('.card__job[data-id=' + jobId + ']').
                hasClass('card__job--preview'))
          addToJobIdsSessionStorage(jobId, $('#jobPreview').html());
      }

      //We add the jobid from the job_favorite history
      var data = {};
      data.jobid = jobId;
      userEventTracket('job_favorite', data);
    }

  }
}

/**
 * Get's user favorite history and flag job listing job cards
 * @returns {boolean}
 */
function checkFavoritesOnJobListing() {
  if (domain.jobSeekerLogin === '0' || $('.card__job').length == 0) {
    return true;
  }
  getUserHistory('job_favorite', function(objResponse) {
    objResponse.list.forEach(function(entry) {
      $('.card__job[data-id=' + entry.jobid + ']').
          find('.button--fav').
          addClass('active-fav');
    });
  }, function(response) {
    return true;
  });
}

/**
 * This will check if the element is partial view
 * @param html elem
 * @returns {boolean|boolean}
 */
function isElementInPartialView(elem) {
  var rect = elem.getBoundingClientRect();
  var elemTop = rect.top;
  var elemBottom = rect.bottom;

  // Partially visible elements return true:
  var isVisible = elemTop < window.innerHeight && elemBottom >= 0;
  return isVisible;
}

/**
 * This will check if the element is total view
 * @param html elem
 * @returns {boolean|boolean}
 */
function isElementInTotalView(elem) {
  var rect = elem.getBoundingClientRect();
  var elemTop = rect.top;
  var elemBottom = rect.bottom;

  // Only completely visible elements return true:
  var isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
  return isVisible;
}

/**
 * General scroll prevention function
 */
function preventBodyScroll() {
  $('html, body').addClass('no-scroll');
  $('.card--popup').parent().removeClass('collapsed__popup__background');
  
  // Body scroll for accountGating Slide up popup
  if (appStorage.jobSeekerContext === "accountGating" && domain.device == "mobile") {
    // Save user's position
    window.scrollY = $(document).scrollTop().valueOf();

    $('body').css('position', 'fixed');
  }
}

/**
 * If preventBodyScroll was call before
 * this will allow the scroll back
 */
function allowBodyScroll(scrollY = "") {
  $('html, body').removeClass('no-scroll');
  $('html, body').removeClass('no-scroll--showscrollbar');

  // Body scroll for accountGating Slide up popup
  if (appStorage.jobSeekerContext === "accountGating" && domain.device == "mobile") {
    $('body').css('position', 'unset');

    // Validate user's last position and scroll to it
    if (window.scrollY) {
      $(document).scrollTop(window.scrollY);
    }
  }
}

/**
 * General use closePopup if the popup is been attach to the popup__background
 */
function closePopup() {

  allowBodyScroll();

  // The countdown for Account Gating resumes when a jobseeker popup is closed
  if (window.accountGatingTimer) {
    window.accountGatingTimer.resume();
  }
  
  // Track the closure of the popup only if the user is
  if (appStorage.applyType == "talentApply") {

    var panel          = $('.panels__container .panel:visible').attr("id");
    var popupBackgroud = $('.popup__background');

    // Params for Uet
    var params       = {};
    params.eventName = "apply_exit";
    params.step      = "apply_exit";

    if (appStorage?.applyStep) {
      params.step = appStorage.applyStep;
    }
    if (appStorage?.easy_apply) {
      params.easy_apply = appStorage.easy_apply;
    }
    if (appStorage?.applyStandardQuestions == "0") {
      params.questions_panel = panel;
    }
    registerEventApply(params);
  }


  let clicked = "";
  // Validate that event is not undefined
  if (event !== undefined) {
    clicked = event.currentTarget.className;
  }

  // Adding closePushPopup event validations
  if (appStorage.isPushNotificationPopupShown == "yes" && clicked == 'icon--closeIcon') {
    // Check if pushNotificationForm exists
    var isPushPopup = document.getElementsByClassName('pushNotificationForm');

    //Only register uet event for closePushPopup if isPushPopup element exists
    if (isPushPopup !== null) {
      // Actions for close permission
      var params = {}
      params.job_id = appStorage.activeJobId;
      params.country = domain.country;
      params.pagetype = "closePushPopup";
      params.version = "V01";
      sendEventToUET("pageview", params);
    }
  }

  $('.popup__background').removeClass('is--active');
  $('.popup__background').html('');
}

/**
 * Close popup after some time to avoid browsers to block the tab
 * @param timeToClose
 */
const closePopupTimeOut = (timeToClose = 100) => {
  setTimeout(() => {
    closePopup();
    location.reload();
  }, timeToClose);
}

/**
 * General use closePopup if the popup is been attach to the popup__background
 */
function showPopup() {
  $('.popup__background').addClass('is--active');
}

/**
 * General use closePopup went the user click on the
 * fade background of the popup.
 */

function closePopupBackground() {
  $('.popup__background').on('mousedown', function(e) {
    if (e.target !== this)
      return;
    closePopup();
  });
}

/**
 * Remove general use closePopup went the user click on the
 * fade background of the popup.
 */

function removeClosePopupBackgroundEvent() {
  $('.popup__background').unbind();
}

/**
 * Sets a Cookie with the key and value given
 * @param string cookieName    key of the cookie
 * @param string cookieValue   value of the cookie
 * @param int    expireDays    number of days that the cookie will be valid
 */
function setCookie(cookieName, cookieValue, expireDays) {

  var d = new Date();
  d.setTime(d.getTime() + (expireDays * 24 * 60 * 60 * 1000));
  var expires = 'expires=' + d.toUTCString() + ';';

  document.cookie = cookieName + '=' + cookieValue + ';' + expires +
      'SameSite=Lax;path=/;domain=.talent.com;';
}

/**
 * Gets a Cookie value
 * @param  string cookieName    String key of the cookie
 * @returns {string}
 */

function getCookie(cookieName) {
  var name = cookieName + '=';
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return '';
}

/**
 * return an array with all the $_GET variables
 * @returns {{}}
 */

function getUrlVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,
      function(m, key, value) {
        vars[key] = value.split('#').shift();
      });
  return vars;
}

/**
 * Will return an specific value on the $_GET parameters, if not found it will
 * return an empty string ""
 * @param value
 * @returns {string}
 */
function getUrlSingleVar(value) {
  var value = getUrlVars()[value];
  if (!value) {
    value = '';
  }
  return value;
}

/**
 * This will setup the cookie preferred_language for 30 days went the user
 * clicks on the language menu.
 */
function preferredLanguageCookieSetup() {
  //We want to target the languages links on the menu
  $('.menu .languageMenuLink').click(function(event) {
    //prevent the links to act out
    if (event.stopPropagation) {
      event.stopPropagation();
      event.preventDefault();
    }
    //We get the current element been click
    var element = event.currentTarget;
    //We get the language value from the element
    var value = $(element).attr('data-lang');
    //Setting up the cookie preferred_language value
    setCookie('preferred_language', value, 30);
    //After that we just send the user to their final destination
    var link = $(element).find('a').attr('href');
    window.location.href = link;
  });
}

/**
 * Delete a Cookie with the given key
 * @param string cookieName
 */
function deleteCookie(cookieName) {
  document.cookie = cookieName +
      '=; expires=Thu, 01 Jan 1970 00:00:00 UTC;SameSite=Lax;path=/;domain=.talent.com;';
}

/**
 * Change type of a password input to text, so we can show the user the
 *  password that they are input
 * @param inputName the HTML attribute name of the input (ex <input name=test >
 * @param elem      the button that is been click for this event to trigger
 */

function showPassword(inputName, elem) {

  // We look for the target input that we want to change their current type
  var input = $('input[name=' + inputName + ']');

  // if their type is password we change it to text and change the button icon
  // to demostrate that their password is been show or hidden
  if (input.attr('type') == 'password') {
    input.attr('type', 'text');
    elem.addClass('has--show');
  } else {
    // but if their type was already text, we want to restore the password type
    // and reverse the icon to the hidden state
    input.attr('type', 'password');
    elem.removeClass('has--show');
  }
}

/**
 * This will send the user to the jobsource of the active job, on white page is
 * the current job, on SERP is the active job preview
 * @returns {boolean}
 */
function sendToJobSource(targetSource) {

  if (targetSource == null) {
  targetSource=0;
  }

  var link = '/redirect?id=' + appStorage.activeJobId + '&lang=' +
      domain.language +
      '&k=' +
      app.keyword + '&l=' + app.location +
      '&context=' + app.pageName + '&nb=true&action=f-link';

  if (app.pageName == 'serp') {

    if ($('.card__job[data-id=' + appStorage.activeJobId + ']').length) {
      link = $(
          '.card__job[data-id=' + appStorage.activeJobId + '] .link-job-wrap').
          attr('data-link');

      link = link + '&nb=true&action=f-link';

    } else if($('.card__job-other-job[data-id=' + appStorage.activeJobId + ']').length) {

      link = $('.card__job-other-job[data-id=' + appStorage.activeJobId + ']').
          attr('data-link');
      link = link + '&nb=true&action=f-link';
    }

  }

  if(app.pageName == "whitepageBulk"){
    link = '/redirect?id=' + appStorage.activeJobId + '&lang=' +
        domain.language +
        '&k=' +
        app.jobTitle + '&l=' + app.jobLocation +
        '&context=' + app.pageName + '&nb=true&action=f-link';
  }
  // Passing country so that animation redirect works
  link += '&country=' + domain.country

  var target = '_self';

  //If the targetSource (our flag) is true...
  //Take the 25% of traffic for A/B test
  if(targetSource==1){
    //Select random number between 0 and 100
    var needle=Math.floor(Math.random() * 100);
    //If the number is under 25... should open a new window
    if ( needle <= 50) {
      var target = '_blank';
    }else{
      //If opens in the same window, mark this parameter as 0
      targetSource=0;
    }
  }

  //Passing parameter to know if was new tab or not
  link += '&targetSource='+targetSource;

      window.open(link, target);
  return true;
}


/**
 * Takes the email input from the check user step and
 * if they don't have a jobSeeker account, we promnt that view
 * if they do we ask then to log in.
 */
function applyPopupEmailStep() {
  // Get email value
  var email = $('input[name=emailCheck]').val().trim();

  // Store the email account for verification processes
  appStorage.email = email;

  // Check if the email is correct, if it not correct we show then an error message
  if (verifyEmail(email)) {
    // Check if the email given have an jobSeeker account attach to it
    checkAccount(email, function(response) {
      // Display the legacy popup for account login process (email and password)
      showJobSeekerPopup('signInJobSeekerStep');

    }, function(response) {
      // if they dont have an account we ask then to create an account
      if (getUrlSingleVar('context') == 'messenger') {
        showJobSeekerPopup('createJobSeekerStep', '', '',
            appStorage.easyLoginInfo, 'talent');
      } else {
        showJobSeekerPopup('createJobSeekerStep');
      }
    });
  } else {
    // Showing error message if the email was not a valid one
    $('input[name=emailCheck]').addClass('has--error');
    $('.error-message[data-for=emailCheck]').addClass('has--error');
  }

}

/**
 * Takes the popup email + password combination and sign in the jobSeeker
 * if their information is valid, if their account is not been confirm we resend
 * the confirmation email and show then the confirmation panel. If they do have
 * confirm their account we send then to the source
 */
function signInApplyPopup() {
  // Inputs from the popup
  var email = $('input[name=emailLogin]').val().trim();
  var password = $('input[name=passwordLogin]').val();
  var rememberMe = false;
  var country = domain.country;
  var language = domain.language;
  var platform = 'talent';
  var uit = '';
  // isValid default value if true, if one of the inputs is wrong, this value will
  // change to false.
  var isValid = true;

  // Clean previous error messages
  $('.has--error').removeClass('has--error');

  // If the email is not valid we show the error message for that field
  if (!verifyEmail(email)) {
    $('input[name=emailLogin]').addClass('has--error');
    $('.error-message[data-for=emailLogin]').addClass('has--error');
    isValid = false;
  }

  // If the password is not valid we show the error message for that field
  if (!verifyPassword(password)) {
    $('input[name=passwordLogin]').addClass('has--error');
    $('.error-message[data-for=passwordLogin]').addClass('has--error');
    isValid = false;
  }
  // If they check remember me we change the value to be true
  if ($('input[name=rememberMe]').is(':checked')) {
    rememberMe = true;
  }

  // if isValid still is true, we try to sign in the user
  if (isValid) {
    loginJobSeeker(email,
        password,
        country,
        language,
        rememberMe,
        platform,
        uit,
        function(response) { // sucessful log in route

          // if the account haven't been confirm we resend the confirmation
          // code email, and send then to that panel.
          if (response.status == 'not_confirmed') {
            showJobSeekerPopup('confirmCodeStep');
          } else {
            // Tracking the search when account creation is a success
            try {
              if (app.pageName == 'serp') {
                addUserSearchToEventHistory();
              }
            } catch (e) {
            }

            //If the context is apply we need to check if it is a quick apply
            //job or not
            if (appStorage.jobSeekerContext == 'apply') {
              //IF it is a quick apply job we need to check if the user's
              // have a CV or not
              if (appStorage.applyType == 'talentApply') {
                getUserStatus(function(response) {
                  // Add the reload value this variable so when a user is logged
                  // and tries to apply a job, the application process popups will have
                  // a close and reload effect when the popup is closed
                  appStorage.closeAndReload = "reload";
                  //If they do we don't ask for a CV on the application process
                  if (response.hasCV == 'true') {
                    routingApplyPopupProcess('false');
                  } else {
                    routingApplyPopupProcess('true');
                  }
                });
              } else {
                //If it is not a quick apply job we just send then to the source
                sendToJobSource();
              }
            } else if (appStorage.jobSeekerContext === "gfj") {
              newEndpointAccountCreation();
            } else {
              routingEndPointAccountCreation();
            }

          }

        }, function(response) { // fail log in route
          //If they where using an SSO then we quickply send them to log in with it
          if (response.reason == 'sso') {
            showJobSeekerPopup('signInAPIStep', '', '', '', response.platform);
          } else {
            // If the Password is invalid, print the error only below the
            // password input
            if (response.reason == "password") {
              $('input[name=passwordLogin]').addClass('has--error');
              $('.error-message[name=passwordLogin]').
                  html(response.user_message);
              $('.error-message[data-for=passwordLogin]').addClass('has--error');
            }
            else {
              // Error for the password + email combination
              $('input[name=passwordLogin]').addClass('has--error');
              $('input[name=emailLogin]').addClass('has--error');
              $('.error-message[data-for=SignInForm]').
                  html(response.user_message);
              $('.error-message[data-for=SignInForm]').addClass('has--error');
            }
          }

        });
  }

}

/**
 * If the email is valid and the limit for password reset email haven't been
 * reach we send the user the email with the instructions of how to reset
 * their password
 */

function resetPasswordSendEmailPopup() {
  // Inputs from the popup
  var email = $('input[name=emailReset]').val().trim();
  var country = domain.country;
  var language = domain.language;
  // isValid default value if true, if one of the inputs is wrong, this value will
  // change to false.
  var isValid = true;

  // Clean previous error messages
  $('.has--error').removeClass('has--error');

  // If the email is not valid we show the error message for that field
  if (!verifyEmail(email)) {
    $('input[name=emailReset]').addClass('has--error');
    $('.error-message[data-for=emailReset]').addClass('has--error');
    isValid = false;
  }
  // if isValid still is true, we try to send the reset password email
  if (isValid) {
    resetPasswordSendEmail(email, country, language, function() {

      // Validate if we are in the new routing
      let legacyRoute = true;
      if (appStorage.newRouting === true) {
        legacyRoute = false;
      }

      // if we were able to send then the email we show then the
      // Success reset password email send panel.
      showJobSeekerPopup('resetPasswordSuccessStep','','','','',legacyRoute);
    }, function() {

    });
  }

}

/**
 * Show the country selector on the account creation process
 */

function accountShowCountrySelector(){
  $("select[name=countryCreate]").closest(".inputWrap").removeClass("is--hidden");
  $("#countryMiddleButton").addClass('is--hidden');
  $(".js-acLabelCountry").hide();
}

/**
 * This will update the autocomplete of the account creation process based on the
 * selected country select input #countryCreate
 */
function updateSelectedCountryAccountCreation() {

  //First we get the country value Ex: 'us', 'ca', 'de'
  var countrySelected = $('#countryCreate').val();
  //Then we take the the data-lang on that option selected, because the auto
  // enableAutoCompleteLocationOnAccountProcess required a langauge as well
  var languageSelected = $(
      '#countryCreate option[value=' + countrySelected + ']').attr('data-lang');

  //We need to store this information for product placement
  appStorage.jobSeekerCountry = countrySelected;

  //We update the autocomplete location with this information
  enableAutoCompleteLocationOnAccountProcess(countrySelected, languageSelected);

}

/**
 * Create jobSeeker account with the information given in the create account
 * step
 */

function createJobSeekerPopup() {
  //prevent the links to act out
  if (event.stopPropagation) {
    event.stopPropagation();
    event.preventDefault();
  }
  // Inputs from the popup
  var firstName = $('input[name=firstName]').val().trim();
  var lastName = $('input[name=lastName]').val().trim();
  var email = $('input[name=emailCreate]').val().trim();
  var location = $('input[name=applicantLocationCity]').val().trim();
  var countryCreate = $('select[name=countryCreate]').val();
  var platform = $('input[name=platform]').val().trim();
  var messengerUserID = $('input[name=messengerUserID]').val().trim();
  var messengerPageID = $('input[name=messengerPageID]').val().trim();
  var password = $('input[name=passwordCreate]').val().trim();
  var phoneNumber = '';
  var phonePlatform = '';
  var rememberMe = false;
  var emailAllow = false;
  var country = domain.country;
  var language = domain.language;
  var languageFolder = domain.settings.language_folder;

  // isValid default value if true, if one of the inputs is wrong, this value will
  // change to false.
  var isValid = true;
  // Clean previous error messages
  $('.has--error').removeClass('has--error');

  // First name and Last name need to have at least one input, if is not
  // valid we show the error message
  if (firstName == '') {
    $('input[name=firstName]').addClass('has--error');
    $('.error-message[data-for=firstName]').addClass('has--error');
    isValid = false;
  }
  if (lastName == '') {
    $('input[name=lastName]').addClass('has--error');
    $('.error-message[data-for=lastName]').addClass('has--error');
    isValid = false;
  }

  // Email verification, if is not valid we show the error message
  if (!verifyEmail(email)) {
    $('input[name=emailCreate]').addClass('has--error');
    $('.error-message[data-for=emailCreate]').addClass('has--error');
    isValid = false;
  }
  //Location varification, if empty we show the error message
  if (location == '') {
    $('input[name=applicantLocationCity]').addClass('has--error');
    $('.error-message[data-for=applicantLocationCity]').addClass('has--error');
    isValid = false;
  }
  // Password verirification, if is not valid we show the error message
  if (!verifyPassword(password)) {
    $('input[name=passwordCreate]').addClass('has--error');
    $('.error-message[data-for=passwordCreate]').addClass('has--error');
    isValid = false;
  }

  // ToS checkbox verification, it need to be check in order to move forward
  // we show the error message
  if ($('input[name=rememberMe]').length) {
    if ($('input[name=rememberMe]').is(':checked')) {
      rememberMe = true;
    }
  } else {
    rememberMe = true;
  }

  // ToS checkbox Email verification, it need to be check in order to move forward
  // we show the error message
  if ($('input[name=allowEmail]').length) {
    if ($('input[name=allowEmail]').is(':checked')) {
      emailAllow = true;
    }
  } else {
    emailAllow = true;
  }

  if (isValid) {
    createJobseeker(firstName,
        lastName,
        email,
        password,
        country,
        language,
        location,
        rememberMe,
        emailAllow,
        platform,
        phoneNumber,
        phonePlatform,
        messengerUserID,
        countryCreate,
        function(response) {

          // Check if the messengerUserID comes from messenger bot
          if (messengerUserID) {
            $.ajax({
              url: '/ajax/messenger/accountCreationConfirmation.php',
              method: 'post',
              async: false,
              dataType: 'json',
              data: {
                messengerUserID: messengerUserID,
                messengerPageID: messengerPageID,
              },
            });
          }

          // Tracking the search when account creation is a success
          try {
            if (app.pageName == 'serp') {
              addUserSearchToEventHistory();
            }
          } catch (e) {}
          //If they user their email to create the account and not a SSO
          //we show the user the confirmation step
          if (response.platform == 'talent') {

            // We show the confirmation step (createJobseeker, already send the
            // confirmation email via php and the jobSeeker class)
            showJobSeekerPopup('confirmCodeStep');
          } else {
            routingPhoneNumberProcess();
          }

        }, function(response) {
          // If the email given was already taken we show the error message from
          // the ajax call
          if (response.reason == 'User already exists') {
            $('input[name=emailCreate]').addClass('has--error');
            $('.error-message[data-for=CreateForm]').
                text(response.user_message);
            $('.error-message[data-for=CreateForm]').addClass('has--error');
          }
          if (response.reason == 'Invalid Phone Number') {
            $('input[name=phone]').addClass('has--error');
            $('.error-message[data-for=phone]').addClass('has--error');
          }
          if (response.reason == 'Password too weak') {
            $('input[name=passwordCreate]').addClass('has--error');
            $('.error-message[data-for=passwordCreate]').addClass('has--error');
          }

        });
  }

}

/**
 * Apply popup process routing
 */
function routingApplyPopupProcess(askForCV) {
  //If it is quick apply we ask for the CV as the next step on the process
  if (appStorage.applyType == 'talentApply') {
    //IF we need to ask for the CV we change the step of the user's
    var step = 'applySummary';
    if (askForCV === 'true') {
      step = 'userCVUpload';
    }
    //Show the popup the user's needs to go
    showJobSeekerPopup(step);
    //We register the application information with the step
    registerApplyConvertionForApplyPopup(step);
  } else {
    //If it is not quickApply we just send then to the endpoint of the registration
    // process
    routingEndPointAccountCreation();
  }

}

/**
 * Registering apply convertion on the application popup went the apply process
 * starts and all this information will be store on the event talent_apply_popup
 * @param step string | application step taken
 */
function registerApplyConvertionForApplyPopup(step) {

  //Request location
  var where = '/ajax/applyProcess/storeApplyConvertionForApplyPopup.php';

  var params = {};
  //Information to be register
  params.jobid = appStorage.activeJobId;
  params.step = step;
  params.country = domain.country;
  $.get(where, params, function(response) {
  });

}

/**
 *
 */
function sendPhoneNumberJobSeekerPopup() {
  var phoneNumber = $('input[name=phone]').cleanVal().trim();
  var phonePlatform = $('input[name=phonePlatform]').val();
  var isValid = true;

  // Clean previous error messages
  $('.has--error').removeClass('has--error');

  //If there is a phone platform setup then the phone number becomes
  //required
  if (phoneNumber == '') {
    $('input[name=phone]').addClass('has--error');
    $('.error-message[data-for=phone]').addClass('has--error');
    isValid = false;
  }

  var params = {};
  params.phone = phoneNumber;
  params.phonePlatform = phonePlatform;

  if (isValid) {
    sendJobseekerPhoneNumber(phoneNumber,phonePlatform, domain.country, domain.language,
        function() {
          showJobSeekerPopup('confirmPhoneNumberCodeStep');
        }, function() {
          $('input[name=phone]').addClass('has--error');
          $('.error-message[data-for=phone]').addClass('has--error');
        });
  }

}

/**
 * Confirm jobSeeker account if the code given in the popup is valid
 */
function confirmPhoneNumberCodePopup() {
  // Inputs from the popup
  var code = $('input[name=confirmCode]').val();

  // isValid default value if true, if one of the inputs is wrong, this value will
  // change to false.
  var isValid = true;
  // Clean previous error messages
  $('.has--error').removeClass('has--error');

  // Code ened to be 4 digits only
  // if (code.length != 4) {
  //   $('input[name=confirmCode]').addClass('has--error');
  //   $('.error-message[data-for=confirmCode]').addClass('has--error');
  //   isValid = false;
  // }

  // if its all good we send the inform
  if (isValid) {
    confirmJobSeekerPhoneNumber(code, function() {
      if(appStorage.jobSeekerContext == 'apply'){
        routingApplyPopupProcess();
      }else{
        showJobSeekerPopup('userSuccessfulConfirmation');
      }


    }, function() {
      // Show error message if something is wrong with the code
      $('input[name=confirmCode]').addClass('has--error');
      $('.error-message[data-for=errorConfirm]').addClass('has--error');
    });
  }

}

/**
 * Upload the user's CV from the jobSeeker popup
 */
function uploadCVtoJobSeekerProfile() {

  //Gather data
  var filename = $('input[name=file-cv]').val();
  var input = document.getElementById('cv');
  var file = input.files[0];

  //Remove any old error messages
  $('.has--error').removeClass('has--error');

  var isValid = true;

  //If the CV is empty we show the error to the user
  if ($('input[name=file-cv]').val() === '') {
    $('.button--uploadFile[for=cv]').addClass('has--error');
    $('.error-required[data-for=cv]').addClass('has--error');
    isValid = false;
  }

  //If all is good we send the information to the profile manager
  if (isValid) {
    //Forming the request
    var fd = new FormData();
    var xhr = new XMLHttpRequest();
    //If there is a file in th einput we need to also add this to the request
    if (file) {
      fd.append('cv', file);
    }

    fd.append('file-cv', filename);
    fd.append('section', 'basicInfo');

    var where_to_upload = '/ajax/jobSeeker/manageJobseekerProfile.php';

    xhr.open('POST', where_to_upload, true);
    xhr.onload = function(response) {
      var obj = JSON.parse(xhr.responseText);
      //If the all is good we show the summary popup
      if (obj.result === 'ok') {
        appStorage.panel = "panel-summary";
        showJobSeekerPopup('applySummary');
      }
    };
    //Sending all the information
    xhr.send(fd);
  }

}

/**
 * Update basic user information, email, first name and last name
 * if they confirm their email
 */
function updateUserEmailApplyPath(){
  if (event.stopPropagation) {
    event.stopPropagation();
    event.preventDefault();
  }
  //Code information
  var code = $('input[name=confirmCode]').val();
  //confirm code with the email
  simpleOTPemailConfirm(code, appStorage.email, function() {
    //Update the basic information
    updateUserApplyInfo(appStorage.quickApplyFirstName,
        appStorage.quickApplyLastName, appStorage.email, function() {
          //Send the application information
          sendApplicationInformation();
        }, function() {

        });

  }, function() {
    //If the code is wrong we show the error message
    $('input[name=confirmCode]').addClass('has--error');
    $('.error-message[data-for=confirmCode]').addClass('has--error');
  });

}

/**
 * This will take the email and confirmed with the code generatorn, and return
 * if the code is okay or not
 * @param code
 * @param email
 * @param successFunction
 * @param failFunction
 */

function simpleOTPemailConfirm(code,email,successFunction,failFunction){
  //Variables
  var params = {};
  params.email = email;
  params.code = code;
  // Ajax file location
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/simpleConfirmEmailOTP.php';
  //Ajax call
  $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;

      //Response routing
      if (objResponse.response == 'ok') {
        //Excecute the success function if we detect that the code is correct
        successFunction(objResponse);
      } else {
        //Excecute the fail function if we detect that the code is incorrect
        failFunction(objResponse);
      }
    },
  });
}

/**
 * This will update the user apply informaiton, first name, last name, email
 * @param firstName
 * @param lastName
 * @param email
 * @param successFunction
 * @param failFunction
 */
function updateUserApplyInfo(firstName,lastName,email,successFunction,failFunction){
  var params = {};
  params.email = email;
  params.firstName = firstName;
  params.lastName = lastName;
  // Ajax file location
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/updateUserApplyInfo.php';
//Ajax call
  $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;

      //Response routing
      if (objResponse.response == 'ok') {
        //Excecute the success function the data was succesfuly updated
        successFunction(objResponse);
      } else {
        //Excecute the fail function if there was a problem updating the data
        failFunction(objResponse);
      }
    },
  });
}

/**
 * This will send the confirmation email for the applicant using the application ID provided by the apply process
 * @param applicationID
 */
function sendApplicationEmail(applicationID) {
  var fd = new FormData();
  var xhr = new XMLHttpRequest();

  fd.append('applicationID', applicationID);

  var where_to_upload = '/ajax/jobSeeker/jobSeekerSendApplicationEmail.php';

  xhr.open('POST', where_to_upload, true);
  xhr.send(fd);
}

/**
 * This will send the application information to the client's server using the application ID provided by the request process.
 * @param applicationID
 */
function sendApplicationToClientServer(applicationID, activeDelivery, easyApply) {
  let fd = new FormData();
  let xhr = new XMLHttpRequest();

  fd.append('applicationID', applicationID);
  fd.append('activeDelivery', activeDelivery);

  const where_to_upload = '/ajax/jobSeeker/sendApplicationToClientServer.php';

  xhr.open('POST', where_to_upload, true);
  $(".button--primary.button--popup").addClass("is--disable");
  xhr.onload = function(response) {
    if(xhr.responseText){
      var obj = $.parseJSON(xhr.responseText);
      obj = obj.payload;
      if (obj.redirect_url) {
        // Show redirection Panel
        appStorage.redirect_url   = obj.redirect_url;
        appStorage.panel          = "redirect_to_source";
        showApplyPopup("redirectToSource");
      }
    }
  };
  xhr.send(fd);
}

/**
 * Confirm jobSeeker account if the code given in the popup is valid
 */
function confirmCodePopup() {
  // Inputs from the popup
  var code = $('input[name=confirmCode]').val();

  // isValid default value if true, if one of the inputs is wrong, this value will
  // change to false.
  var isValid = true;
  // Clean previous error messages
  $('.has--error').removeClass('has--error');

  // Code ened to be 4 digits only
  // if (code.length != 4) {
  //   $('input[name=confirmCode]').addClass('has--error');
  //   $('.error-message[data-for=confirmCode]').addClass('has--error');
  //   isValid = false;
  // }

  // if its all good we send the inform
  if (isValid) {
    confirmJobSeekerEmail(code, function() {

      routingPhoneNumberProcess();

    }, function() {
      // Show error message if something is wrong with the code
      $('input[name=confirmCode]').addClass('has--error');
      $('.error-message[data-for=errorConfirm]').addClass('has--error');
    });
  }

}

/**
 * Phone number registration process path, if the domain.allowSMSandWA is 1
 * it means that the country have a SMS and WA strategy and phone number needs
 * need to be ask furing the account creation process
 */
function routingPhoneNumberProcess(){

  //If the country have a SMS and WA strategy we move to the phone popup
  if (domain.allowSMSandWA == 1 &&
      appStorage.jobSeekerCountry == domain.country) {
    // Use the following validation to allow the page to reload when
    // the user clicks in the close button of the Upload CV Process
    if (appStorage.jobSeekerContext === 'apply' &&
        appStorage.applyType == 'talentApply') {
      appStorage.closeAndReload = "reload";
      if( domain.testGroup == 'A' &&
          domain.testName == 'sms_account_creation'){
        //Show the phone number popup
        showJobSeekerPopup('userPhoneNumber');
      }else{
        // Show application route
        routingApplyPopupProcess('true');
      }
      return true;
    }else{
      //Show the phone number popup
      showJobSeekerPopup('userPhoneNumber');
    }

  } else {
    // There is no need for confirming the user on other registration
    // platforms, also if the context is apply, we sendthen to the application
    // process for the other ones we just show then a popup.
    if (appStorage.jobSeekerContext === 'apply') {
      appStorage.closeAndReload = "reload";
      routingApplyPopupProcess('true');
    } else {
      showJobSeekerPopup('userSuccessfulConfirmation');
    }
  }

}

/**
 * logs out the user by removing the user-token cookie and refreshing
 * the site
 */
/*
function logoutJobSeeker() {
  // jobSeeker log out logout location
  var where = '/ajax/jobSeeker/logoutJobSeeker.php';
  $.get(where, '', function(response) {
    location.reload();
  });
}
*/
/**
 * This determents what happen went a users does the following:
 * Finish the account creation process
 * Successful sign in/Login with ANY of the  options (SSO or Email)
 * @param reload string If you don't want the site to reload set it to 'false'
 */

function routingEndPointAccountCreation(reload) {
  //We send the user to the job source if they successfuly confirm their account
  // and we close the popup
  if (getUrlVars()['action'] == 'create') {
    // Account creation flag
    appStorage.accountCreation = 'yes';
  }

  if (getUrlVars()['uit']) {
    replaceStateURL('uit', '');
    replaceStateURL('action', '');
    replaceStateURL('platform', '');
    replaceStateURL('jobSeekerContext', '');
  }
   /*Push Notification Show Popup during User Creation process
     Case when a user tries to create an account using SSO in UK, we display
     the Push notification Popup
     domain.allowPushNotification represents the countries that are allowed
     appStorage.bulkRoute are the pages that come from whitepage
     appStorage.accountCreation if the account is being created
     appStorage.isPushNotificationPopupShown if the popup has been showed already
     appStorage.isPushNotificationPopupOnWhitepage if we are on whitepage
     appStorage.jobSeekerContext the salary widget popup cannot trigger the push notification popup*/
 /*
  if (
      domain.allowPushNotification == "1" &&
      appStorage.bulkRoute == "true" &&
      appStorage.accountCreation == 'yes' &&
      appStorage.isPushNotificationPopupShown === undefined &&
      appStorage.isPushNotificationPopupOnWhitepage === undefined &&
      appStorage.jobSeekerContext != 'salaryWhitepageWidget'
  ) {
    //Apply process context
    if (appStorage.jobSeekerContext == 'apply') {
      var data = {};
      data.jobid = appStorage.activeJobId;
      userEventTracket('job_ioa', data);
    }

    saveNotificationDefaultStatus(Notification.permission);
    // Ask the browser if the notifications are allowed before displaying the popup
    if (Notification.permission != "denied") {
      appStorage.isPushNotificationPopupShown = 'yes';
      appStorage.isPushNotificationPopupOnWhitepage = 'yes';
      showJobSeekerPopup("popupPushNotification");
      return false;
    }
  }
  */
  //SSO invalid sign in context
  if (appStorage.jobSeekerContext == 'invalid_signin') {
    appStorage.jobSeekerContext = getUrlVars()['jobSeekerContext'];
  }

  deleteStorageWhenLogin(appStorage.jobSeekerContext);

  //Apply process context
  if (appStorage.jobSeekerContext == 'apply') {
    var data = {};
    data.jobid = appStorage.activeJobId;
    if (app.pageName == 'serp') {
      data.searchLocation = $('#nv-l').val();
    }
    // To continue the apply flow, to process the application
      if (appStorage.flow == 'talentApplyOtp') {
          appStorage.closeAndReload   = (domain.jobSeekerLogin == "1") ? "no" : "reload";
          appStorage.panel      = "panel-summary";
          appStorage.applyStep  = "applySummary";
          showApplyPopup('applySummary');
          return true;
      }

    userEventTracket('job_ioa', data);
    sendToJobSource();

  } else if (appStorage.jobSeekerContext == 'user-page') {
    var url = getUrlVars();
    var params = Object.entries(url).
        map(item => item[0] + '=' + item[1]).
        join('&');

    if (typeof appStorage.jobSeekerUserPage == 'undefined') {
      appStorage.jobSeekerUserPage = 'user-pages'
    }

    window.location.href = domain.settings.language_folder +
        appStorage.jobSeekerUserPage + '?' + params;
  }
  //Home page context
  else if (appStorage.jobSeekerContext == 'home') {
    let refererProcess   = appStorage.popupHistory.includes("verifyStep") ? "user-create" : "user-login";
    window.location.href = `${domain.settings.language_folder}/jobs?referer_process=${refererProcess}`;
  }
  //Favorites process
  else if (appStorage.jobSeekerFavToAdd != '' && (appStorage.jobSeekerContext == 'favorites' || appStorage.jobSeekerContext == 'accountGating_savejob')) {

    //We add the jobid from the job_favorite history
    let formData       = new FormData();
    const where        = '/ajax/page_jobs/registerJobFavorite.php';
    const jobId        = appStorage.jobSeekerFavToAdd ?? sessionStorage.getItem('job-to-save');
    let favoriteParams = loadDataForFavoriteEvents(jobId, "save");

    for (let key in favoriteParams) {
      formData.append(key, favoriteParams[key]);
    }

    fetch(where, {method: 'POST', body: formData})
        .then((response) => {
          location.reload();
        })
  }
  // For serp tailored experience
  else if(appStorage.jobSeekerContext == "warehouse_serp_v2"){

    var url = getUrlVars();
    url.l = appStorage.userLocation;
    var params = Object.entries(url).
        map(item => item[0] + '=' + item[1]).
        join('&');

    window.location.href = domain.settings.language_folder + '?' + params;

  } else if(appStorage.jobSeekerContext == "salaryWhitepageWidget"){

    // Add the language folder to this variable and check if its undefined
    var languageFolder = domain.settings.language_folder;

    // If its undefined, leave it blank
    if (languageFolder == undefined) {
      languageFolder = "";
    }

    window.location.href = languageFolder + "/salary?job="+app.jobTitle;

  } else if (appStorage.jobSeekerContext == "bulk_email_widget") {

    // All Views are stored here
    let endpoint = '/ajax/jobSeeker/popups/accountCreationFlow/_newFlowRouter.php?';

    var viewParams = {};
    viewParams.country  = domain.country;
    viewParams.language = domain.language;
    viewParams.jobid = appStorage.activeJobId;

    // If the user is has succesfully logged in, reload the page
    if (appStorage.isLogginIn == "yes") {
      location.reload();
    }

    // If the country is an enabled OTP country
    if (domain.otpCountry == "1") {
      // If OTP country is true and OTP Skipped is Yes, display successful confirmation popup
      if (appStorage.otpSkip == "yes" || appStorage.accountConfirmed == "yes") {
        // Confirm Account with OTP first
        viewParams.route = "successfulEmailAlertWidget"
        $.get(endpoint, viewParams, function(response){
          renderRequestContentInElement("#c-email-register", JSON.parse(response).payload.HTML);
        });
        return false;
      } else {
        // Display Succesful message
        viewParams.route = "confirmEmailAlertWidget"
        $.get(endpoint, viewParams, function(response){
          renderRequestContentInElement("#c-email-register", JSON.parse(response).payload.HTML);
        });
        return false;
      }
    }

  } else if(appStorage.jobSeekerContext == "bulk_view_description"){
    // Behavior to show popup with job description
    showJobSeekerPopup('wpPopupShowJobDescription');
    return false;

  } else if(appStorage.jobSeekerContext == "bulk_view_description_desktop"){
    // Behavior for the desktop version
    closePopup();
    appStorage.bulkLog = "yes";
    showHideDescription(appStorage.activeJobId);
    return false;

  } else if(appStorage.jobSeekerContext == "bulk_jobs_of_the_day"){
    // Send the user to the job source
    sendToJobSource();

  } else if(appStorage.jobSeekerContext == "job_swipe"){
    // Call the next job function
    closePopup();
    appStorage.bulkLog = "yes";
    appStorage.jobIndex = 3;
    loadNextJobViewMore("", 'no', 'jobsense');
    return false;

  } else if(appStorage.jobSeekerContext == "job_swipe_skip"){
    // Call the next job function
    closePopup();
    appStorage.bulkLog = "yes";
    appStorage.jobIndex = 3;
    loadNextJobViewMore("", 'no', 'jobsense');
    return false;

} else if(appStorage.jobSeekerContext == "dtl_listing_salary_cta") {
    let jobTitle = appStorage.salaryEstimateJobTitle;
    if(jobTitle == ""){
      jobTitle = getUrlSingleVar('salaryEstimateJobTitle');
    }
    // Redirect to salary page
    window.location.href = "/salary?job=" + jobTitle;
  } else if(appStorage.jobSeekerContext == "dtl_questionary") {
    // Add the language folder to this variable and check if its undefined
    var languageFolder = domain.settings.language_folder;

    // If its undefined, leave it blank
    if (languageFolder == undefined) {
      languageFolder = "";
    }
    let url = getUrlVars();
    let params = Object.entries(url).map(item => item[0] + '=' + item[1]).join('&');

    window.location.href = languageFolder + "/dtl/rnd-template/index.php" + '?' + params;
    return false

  } else if (appStorage.jobSeekerContext == 'accountGating' &&
      appStorage.accountCreation == 'yes' && appStorage.accountType != "email") {
    // This behaviour is only for new users, for login users, we just refresh the page
    showJobSeekerPopup("successConfirmation");

  } else if (appStorage.jobSeekerContext == "serpBulkUsersPopUpDefault" || appStorage.jobSeekerContext == "serpBulkUsersPopUpJobSearch" ||
      appStorage.jobSeekerContext == "serpBulkUsersPopUpPagination") {
    // Remove tracked elements
    sessionStorage.removeItem("elemClicks");
    sessionStorage.removeItem("keywords");
    location.reload();
  } else if(appStorage.jobSeekerContext == 'serpBulkUsersPopUpJobClick'){
    sessionStorage.removeItem("elemClicks");
    sessionStorage.removeItem("keywords");
    if(domain.device == "desktop"){
      replaceStateURL('id', appStorage.activeJobId);
      location.reload();
    } else{
      var link = "/redirect?id="+appStorage.activeJobId+"&context=serp&np=true";
      var target = '_self';

      window.open(link, target);
    }

  }else {
    if (reload != 'false') {
      location.reload();
    }

  }
  closePopup();
}

/**
 * This request is to save the notification status in UET
 */
function saveNotificationDefaultStatus(userStatus) {
  $.ajax({
    url: '/ajax/pushNotification/statsEvent.php',
    method: 'get',
    data: {
      'pushType': 'push-continue-' + userStatus
    }
  }).done(function(result){
    //console.log("Default notification status", result);
  })
}

/**
 * This logs out the user's and refresh the site
 */
function logoutJobSeeker() {
  // Delete all application questions when user logout
  deleteLocalApplicationStorage();
  // jobSeeker log out logout location
  var where = '/ajax/jobSeeker/logoutJobSeeker.php';
  $.get(where, '', function(response) {
    location.reload();
  });
}

/**
 * Delete local Storage application
 * When user logout delete from local storage
 * all the element that has the prefix application
 */
function deleteLocalApplicationStorage() {
  // Look into the local storage for the prefix application
  for (var i = 0; i < localStorage.length; i++){
    if (localStorage.key(i).substring(0,11) === "application") {
      localStorage.removeItem(localStorage.key(i));
    }
  }
}

/**
 * This will target the jobSeeker popup router, and show one of the steps depending
 * on the input route
 *
 * route can have the following values:
 *
 * checkEmailStep             for /ajax/jobSeeker/HTML/popupCheckEmailStep.php
 * confirmCodeStep            for /ajax/jobSeeker/HTML/popupConfirmCodeStep.php
 * resetPasswordStep          for /ajax/jobSeeker/HTML/popupResetPasswordJobSeekerStep.php
 * resetPasswordSuccessStep   for /ajax/jobSeeker/HTML/popupResetPasswordSuccessStep.php
 * createJobSeekerStep        for /ajax/jobSeeker/HTML/popupCreateJobSeekerStep.php
 * signInJobSeekerStep        for /ajax/jobSeeker/HTML/popupSignInJobSeekerStep.php
 * signInAPIStep              for /ajax/jobSeeker/HTML/popupReturningAPISignIn.php
 * userCVUpload               for /ajax/jobSeeker/HTML/popupUploadCV.php
 * applySummary               for /ajax/jobSeeker/HTML/popupApplySummary.php
 * userPhoneNumber            for /ajax/jobSeeker/HTML/popupPhoneNumberStep.php
 * confirmPhoneNumberCodeStep for /ajax/jobSeeker/HTML/popupConfirmCodeStep.php
 *
 * Router is in /ajax/jobSeeker/HTML/popupRouter.php
 *
 * @param route string that can take the values showing top
 * @param jobId string the jobid of the job that the user try to apply to
 * @param ioa   string with false or true, if true it will register an ioa
 */

function showJobSeekerPopup(route, jobId, ioa, easySignin, platform, legacy) {

  if (route == "") {
    return true;
  }
  // Adding this variable for account gating tracking to know which popup is getting the click
  appStorage.currentPopup = route;

  // This stores the popup name on the appStorage to keep track of the popup flow
  popupHistory(route);

  // The 30 seconds countdown for Account Gating is paused when a jobseeker popup is opened
  if (window.accountGatingTimer) {
    window.accountGatingTimer.pause();
  }
  
  // if we want to try to register an ioa we first need to check if
  // we are not going to double register that event.
  if (ioa === 'true') {

    // we want to keep a list of the jobs with ioa already register
    if (appStorage.ioaList !== undefined) {
      //if we already have some ids store we just check
      // if the one been click on is on the list
      if (appStorage.ioaList.indexOf(jobId) === -1) {
        //not on the list? then we store it
        appStorage.ioaList = appStorage.ioaList + ',' + jobId;
      } else {
        //if it is already in the list we don't want to send this ioa
        ioa = 'false';
      }
    } else {
      //if this is the first store we just need to put the id
      appStorage.ioaList = jobId;
    }
  }

  if (!easySignin && appStorage.backupUit) {
    easySignin = appStorage.backupUit;
  }

  appStorage.jobSeekerCountry = domain.country;

  if (!platform && appStorage.backupPlatform) {
    platform = appStorage.backupPlatform;
  }
  var source = '';
  if (getUrlVars()['source']) {
    source = getUrlVars()['source'];
  }

  var params = {};
  params.country = domain.country;
  params.language = domain.language;
  params.languageFolder = domain.settings.language_folder;
  params.route = route;
  params.jobid = appStorage.activeJobId;
  params.registerIOA = ioa;
  params.device = domain.device;
  params.jobSeekerContext = appStorage.jobSeekerContext;
  params.uit = easySignin;
  params.platform = platform;
  params.jobSource = source;
  params.forceRegistration = domain.forceRegistration;
  params.at = appStorage.applyType;
  params.newJobSeeker = appStorage.newJobSeeker;
  params.closeAndReload = appStorage.closeAndReload;
  params.accountType = appStorage.accountType;
  params.midStep = appStorage.midStep;
  params.phone = appStorage.phone;
  params.email = appStorage.email;
  params.otpCountry = domain.otpCountry;
  params.allowSMSandWA = domain.allowSMSandWA;
  params.bulkRoute = appStorage.bulkRoute ;
  params.DTLRoute  = appStorage.DTLRoute ;
  params.suggested_mbg = appStorage.suggested_mbg ;
  params.k_mbg = appStorage.k_mbg ;
  params.l_mbg = appStorage.l_mbg ;
  params.bulkInitialPopup = appStorage.displayInitialPopup;
  params.initialPopupShown = appStorage.initialPopupShown;
  params.userLoged = domain.jobSeekerLogin;
  params.confirmAccountSSO = appStorage.confirmAccountSSO;
  params.organicStylePopup = appStorage.organicStylePopup;
  params.activateLinkedinSSO = appStorage.activateLinkedinSSO;
  params.keywordListingBulk = appStorage.keywordListingBulk;
  params.jobSearchLocation = appStorage.jobSearchLocation;
  params.salaryEstimateJobTitle = appStorage.salaryEstimateJobTitle;
  params.displayPopupContentChange = appStorage.displayPopupContentChange;
  params.backPopupAlgo = appStorage.backPopupAlgo;
  params.isSeasonality = appStorage.isSeasonality;
  params.applyType = appStorage.applyType;

  // We need to send the get params for the quality events.
  if (typeof appStorage.getParams !== 'undefined') {
    params.getParams = appStorage.getParams;
  }


  // Validate the app exist and we have the page type set
  if (typeof app === 'object' && app.pageName !== undefined) {
    params.pagetype = app.pageName;
  }

  params.salary = appStorage.salary;
  params.from = appStorage.from;
  params.region = appStorage.region;

  params.searchKeyword = appStorage.k ?? getUrlSingleVar("k");
  params.searchLocation = appStorage.l ?? getUrlSingleVar("l");


  // Account gating variables
  params.accountGatingCollapse = appStorage.accountGatingCollapse;
  params.accountGatingState = appStorage.accountGatingState;
  params.accountGatingKeyword = appStorage.accountGatingKeyword;

  // Used to know if the popup already been displayed and to now display it again for specific context.
  if (appStorage.jobSeekerContext == "accountGating_search") {
    sessionStorage.setItem("popupViewed", true);
  }


  // This is to make sure the account creation does not close if user comes from
  // adwords for tailored exp
  if(appStorage.noClosePopup == "true"){
    params.noClosePopup = appStorage.noClosePopup;
  }
  // JobSeeker router location
  var where = '/ajax/jobSeeker/popups/popupRouter.php';
  // Set the conditions to get the router
  if (domain.otpCountry == "1") {
    // New account creation router flow
    where = '/ajax/jobSeeker/popups/accountCreationFlow/_newFlowRouter.php';
  }

  // Set the condition to call the new routing for account gating process
  if (appStorage.newRouting == true && appStorage.applyType != 'talentApply' && domain.otpCountry == "1") {
    where = '/ajax/jobSeeker/popups/_newPopupRouting/_routing.php';
  }
  if (legacy == true) {
    where = '/ajax/jobSeeker/popups/popupRouter.php';
  }


  // Sending the information to the popups
  $.get(where, params, function(response) {
    var objResponse = $.parseJSON(response);
    // we apprend the response to our general use popup
    hangElementToPopup(objResponse.payload.HTML);
    // we clean the URL from any SSO login information
    if (getUrlVars()['uit']) {
      appStorage.easyLoginInfo = getUrlVars()['uit'];
      replaceStateURL('uit', '');
      replaceStateURL('action', '');
      replaceStateURL('platform', '');
    }
    if (getUrlVars()['jobSeekerContext']) {
      appStorage.easyLoginInfo = getUrlVars()['uit'];
      replaceStateURL('jobSeekerContext', '');
      replaceStateURL('at', '');
    }


  });
}

function hangElementToPopup(html) {

  if ($('#popupBackground').length > 0) {
    $('#popupBackground').html(html);
  } else {
    $('body').
        append(
            '<div class="popup__background" id="popupBackground">' + html +
            '</div>');
  }
  // we show the popup
  showPopup();
  // we prevent the site to scroll
  preventBodyScroll();
  // If account gating showing collapsed
  if(appStorage.accountGatingState == "collapsed") {
    appStorage.accountGatingState = "";
    allowBodyScroll();
  }
  // and we add the background popup event that, if they click on the background
  // it will close the popup

  if (domain.forceRegistration == '' && appStorage.jobSeekerContext !=
      'apply' && appStorage.noClosePopup == "") {
    closePopupBackground();
  } else if(appStorage.noClosePopup == "true" && domain.device == "mobile"){
    removeClosePopupBackgroundEvent();
  } else {
    removeClosePopupBackgroundEvent();
  }

}

/**
 * Render HTML content inside an element
 * You can pass the element class or id, and the content of the request
 * will be rendered in that element or container
 *
 * @param elementName Name of the element, it can be a class, id or attribute
 * @param requestContent HTML response of the previous request
 */
function renderRequestContentInElement(elementName, requestContent) {

  // Check for the element first
  if ($(elementName).length > 0) {
    $(elementName).hide();
    $(elementName).html(requestContent);
    $(elementName).show();
  }
  // Return no errors if the element is not found
  else {
    return false;
  }

}

/**
 * Auto focus the first input without value on the popup
 */

function focusFirstTextInputOnPopup() {
  //get the list of inputs on the popup
  var elementsToFocus = document.getElementById('popupBackground').
      querySelectorAll('.input--text');
  var elementToFocus = "";

  //Foreach element we check if they have a value
  elementsToFocus.forEach(function(el){
        //if they don't have a value we take that one
        if($(el).val() == "" && elementToFocus == ""){
          elementToFocus = el;
        }
      }

  );
  //If there is one we focus it
  if (elementToFocus) {
    elementToFocus.focus();
  }
}

/**
 * Function that triggers the login popup from the menu login button
 * @param jobSeekerContext
 */
function showJobSeekerLogIn(jobSeekerContext) {
  // Add the context added from the click in the login menu button
  appStorage.jobSeekerContext = jobSeekerContext;
  //appStorage.jobSeekerContext = "accountGating";
  // Get the active job id from the url
  appStorage.activeJobId = getUrlSingleVar("id");
  // Adding new routing to show the new popup process
  if (domain.country === "ca") {
    appStorage.newRouting = true;
    delete appStorage["applyType"];
  }
  // Call the check email popup
  showJobSeekerPopup('checkEmailStep');
}

/**
 *  Apply CTA actions, if the jobSeeker is not log in we ask then for their email
 *  and check if they have an account with us, if they do we send then to log in
 *  if they don't we show then the creation account step. In the case they are log
 *  in we send then to the source if they are confirm, if they are not confirm
 *  in that case we ask then to confirm their account on the confirm account step
 * @param jobId  string The id of the job intend to be apply
 * @param source string  The CTA that trigger that application
 * @param isPPC  string If the job is a PPC or not
 * @param isQuickApply string If the job is a quick apply or not
 * @returns {boolean}
 */
function applyRouter(jobId, source, isPPC, isQuickApply, targetSource) {
  // We update the activeJobId value so the sendToJobSource() knows where to go
  appStorage.activeJobId = jobId;
  appStorage.actionSouce = source;
  appStorage.jobSeekerContext = 'apply';
  if (isQuickApply === 1) {
    appStorage.applyType = 'talentApply';
  } else {
    appStorage.applyType = 'source';

  }

  if (app.pageName == 'whitepage') {
    var params = {};
    params.id = app.jobid;
    params.country = domain.country;
    $.get('/ajax/update-ioa-status.php', params, function() {
    });
  }
  if (
      app.applyUser != 'true'
  ) {
    sendToJobSource(targetSource);
    return true;
  }

  // If the apply click comes from the serp then save the event
  if(app.pageName === 'serp') {
    // Any changes to this function pls reflect them on "trackingOpenJobInNewTab()" as well
    //Todo add here the card_position
    saveJobPreviewEvent({'event': 'intentofapply', 'jobId': jobId});
  }

  // If it is a quickApply do not do any other validation
  if (appStorage.applyType == 'talentApply') {

    const params = {};
    params.id = jobId;
    params.njx = 1;
    params.context = "serp";
    params.is_mobile = domain.is_mobile;
    params.is_web = domain.is_web;
    params.api_device = appStorage.apiDevice;

    const cleanedParams = Object.fromEntries(Object.entries(params).filter(([_, v]) => v != null));

    if(app.pageName === 'serp'){
      $.get(`/redirect`, cleanedParams, function(responseText) {
        // console.log(responseText);
      });
    }

    // If the distant_location position exists in the appStorage check if the current jobId is stored in it,
    // this to validate if we already showed the popup for this jobId
    if (!appStorage.distant_location || (appStorage.distant_location && !appStorage.distant_location.includes(jobId))) {
      showApplyPopup('distantLocation');
    } else {
      checkQuestions();
    }

    return true;
  }

  //we try to get the cookie user-token
  var userToken = domain.jobSeekerLogin;

  //if it not empty we are going to check if they are confirm or notresendConfirmationCodeEmail
  if (userToken === '1') {

    var data = {};
    data.jobid = jobId;
    if (app.pageName == 'serp') {
      data.searchLocation = $('#nv-l').val();
    }
    userEventTracket('job_ioa', data);

    // Checking user's status value
    getUserStatus(function(response) {

      // if it is not_confirmed we need to resend the confirmation email
      // and show then the confirm code step on the popup
      if (response.status == 'not_confirmed') {
        showJobSeekerPopup('confirmCodeStep', jobId, 'true');
        return true;
      } else {
        //If it is not a quickApply we just send then to the source
        sendToJobSource(targetSource);
        //if they are confirmed we just send then to the job source
        return true;
      }
    }, function(response) {

      // Adding new routing to show the new popup process
      if (app.source === "google_jobs_apply") {
        appStorage.newRouting = true;
        appStorage.jobSeekerContext = "gfj";
      }

      // if for some reason they have an invalid cookie we are going to delete it
      // and show then the first step of the jobSeeker creation process
      showJobSeekerPopup('checkEmailStep', jobId, 'true');
    });

  } else {
    //If it is a quick apply job we need to store this for routing the user accordingly
    if (isPPC === 1) {
      sendToJobSource(targetSource);
    } else {

      // Adding new routing to show the new popup process
      if (app.source === "google_jobs_apply") {
        appStorage.newRouting = true;
        appStorage.jobSeekerContext = "gfj";
      }

      // if they are not log in we show then the first step of the jobSeeker creation process
      showJobSeekerPopup('checkEmailStep', jobId, 'true');
    }
  }
}

/**
 * Check if an email have an jobSeeker account attach to it
 * @param email Email of the user we want to check
 * @param successFunction Function if the user have an account
 * @param failFunction Function if user does not have an account
 * @param isNotValidEmailDomainFunction Function if user enters an invalid domain
 */
var checkAccountXHR = null;

function checkAccount(email, isUserFunction, isNotUSerFunction, isNotValidEmailDomainFunction) {
  // kill the any XHR request done before the must recent one
  if (window.checkAccountXHR) {
    window.checkAccountXHR.abort();
  }

  var params = {};
  params.email = email;
  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/checkJobSeekerAccount.php';
  // Storing the XHR request if there is a need for killing it because of a
  // new request. So we garantee to send the must recent information.
  window.checkAccountXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {

      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;

      //Response routing
      if (objResponse.response == 'account') {
        //Execute the success function if we detect that the user has
        // an account with that email
        appStorage.accountPasswordType = objResponse.passwordType;
        isUserFunction(objResponse);
      } else if (objResponse.response == 'invalid email domain') {
        // Execute the not valid email domain function when the
        // domain is not valid
        isNotValidEmailDomainFunction(objResponse);
      } else {
        //Execute the fail function if we detect that the user does not have
        // an account with that email
        isNotUSerFunction(objResponse);
      }
    }
  });
}

/**
 * Check if an email have an jobSeeker account attach to it
 * @param extraInformation   Email of the user we want to check
 * @param successFunction    Function if the user have an account
 * @param failFunction      Function if user does not have an account
 */
var sendPhoneNumberXHR = null;

function sendJobseekerPhoneNumber(
    phoneNumber,phonePlatform, country, language, successFunction, failFunction) {
  // kill the any XHR request done before the must recent one
  if (window.sendPhoneNumberXHR) {
    window.sendPhoneNumberXHR.abort();
  }

  var params  = {};
  params.country = country;
  params.language = language;
  params.phone = phoneNumber;
  params.phonePlatform = phonePlatform;
  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/sendPhoneJobseeker.php';
  // Storing the XHR request if there is a need for killing it because of a
  // new request. So we garantee to send the must recent information.
  window.sendPhoneNumberXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;

      //Response routing
      if (objResponse.response == 'ok') {
        //Excecute the success function if we detect that the user haves
        // an account with that email
        successFunction(objResponse);
      } else {
        //Excecute the fail function if we detect that the user does not have
        // an account with that email
        failFunction(objResponse);
      }
    },
  });
}

/**
 * Resend user's confirmation phone number with the code to activate the account
 * @param code
 * @param successFunction
 * @param failFunction
 */


function confirmJobSeekerPhoneNumber(code, successFunction, failFunction) {
  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }

  var params = {};
  params.code = code;
  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/confirmJobSeekerPhoneNumber.php';
  window.confirmJobSeekerEmailXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        // Function sending the email was a success
        successFunction(objResponse);
      } else {
        // Function if something fail trying to send the email, Ex: user already
        // verify or non-existent
        failFunction(objResponse);
      }
      $('.is--waiting').removeClass("is--waiting");
    },
    fail: function(){
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    }
  });
}

/**
 * Check jobSeeker combination for password and email and returns, the response
 * object for sucess or fail log in
 * @param email             Email of the user
 * @param password          Password of the user
 * @param country           ISO (2 letters) for country EX: us,ca,gb
 * @param language          ISO (2 letters) for language EX: en,fr,ge
 * @param successFunction   Funcion if the combination password + email is correct
 * @param failFunction      Function if the combination password + email is not correct
 */

function loginJobSeeker(
    email,
    password,
    country,
    language,
    rememberMe,
    platform,
    uit,
    successFunction,
    failFunction,
) {
  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }

  var params = {};
  params.email = email;
  params.password = password;
  params.country = country;
  params.language = language;
  params.rememberMe = rememberMe;
  params.platform = platform;
  params.jobSeekerContext = appStorage.jobSeekerContext;
  params.applyType = appStorage.applyType;
  params.uit = uit;
  params.conversionTest = appStorage.conversionTest
  params.jobId = getUrlSingleVar("id");

  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/loginJobSeeker.php';

  window.loginJobSeekerXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        //Excecute the success function if the password email combination is
        //correct
        successFunction(objResponse);
      } else {
        //Excecute the fail function if the password email combination is
        //not correct (might be because there is not an account with the input email)
        failFunction(objResponse);
      }
      $('.is--waiting').removeClass("is--waiting");
    },
    fail: function(){
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    }
  });

}

/**
 * Check jobSeeker account status value giving the cookie token
 * @param token           User's id encrypted (usually is on the user-token value)
 * @param successFunction Function if there was not issues returning the status value
 * @param failFunction    Function if there was issues returning the status value
 */

var getUserStatusXHR = null;

function getUserStatus(
    successFunction,
    failFunction,
) {
  // kill the any XHR request done before the must recent one
  if (window.getUserStatusXHR) {
    window.getUserStatusXHR.abort();
  }

  var params = {};
  // Ajax file location, everything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/getJobSeekerStatus.php';

  window.getUserStatusXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        // Execute the success function if the Ajax was able to return the status
        // of the jobSeeker
        successFunction(objResponse);
      } else {
        // Execute the fail function if the Ajax was not able to return the
        // status of the jobSeeker (must likely there is a problem with the token
        // given Ex: account not longer in the database, or a bad token given)
        failFunction(objResponse);
      }
    },
  });
}

/**
 * Creates an jobSeeker account with the given information and return the
 * response object for sucess or fail account
 * @param firstName         First name of the user
 * @param lastName          Last name of the user
 * @param email             Email of the user
 * @param password          Password of the user
 * @param country           ISO (2 letters) for country EX: us,ca,gb
 * @param language          ISO (2 letters) for language EX: en,fr,ge
 * @param location          Location input by the user
 * @param rememberMe        Set to true if you want to keep the user log in
 * @param emailAllow        Set to true if you want to sinal that the users wants emails
 * @param testGroup         Testing value for AB test
 * @param platform          Creation platform (Talent, Google, Facebook, etc.)
 * @param messengerUserId   It comes from messenger chatbot when we're creating an account
 * @param countryCreate     Input country of the user's selects on the process
 * @param successFunction   Function if there account creation was successful
 * @param failFunction      Function if there account creation was not successful
 */


function createJobseeker(
    firstName,
    lastName,
    email,
    password,
    country,
    language,
    location,
    rememberMe,
    emailAllow,
    platform,
    phoneNumber,
    phonePlatform,
    messengerUserId,
    countryCreate,
    successFunction,
    failFunction,
) {
  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }

  // For target experience for SERP (this testId is declared in page-search.js
  // targetExperienceOnLoad on success
  if(appStorage.conversionTest == "warehouse_serp_v2"){

    // Getting the target exp answer from session storage
    var shift = sessionStorage.getItem("shift"),
        startDate = sessionStorage.getItem("startDate"),
        certifications = sessionStorage.getItem("certifications"),
        commute = sessionStorage.getItem("commute");
    // Creating object to send the information
    var targetExperience = {};
    targetExperience.shift = shift;
    targetExperience.startDate = startDate;
    targetExperience.certifications = certifications;
    targetExperience.commute = commute;
    // Clear session storage
    sessionStorage.removeItem("shift");
    sessionStorage.removeItem("startDate");
    sessionStorage.removeItem("certifications");
    sessionStorage.removeItem("commute");
    // Keeping user location for the redirect later on
    appStorage.userLocation = location;
  }

  var params = {};
  params.firstName = firstName;
  params.lastName = lastName;
  params.email = email;
  params.password = password;
  params.country = country;
  params.language = language;
  params.location = location;
  params.countryCreate = countryCreate;
  params.rememberMe = rememberMe;
  params.emailAllow = emailAllow;
  params.context = appStorage.jobSeekerContext;
  params.activeJobId = appStorage.activeJobId;
  params.applyType = appStorage.applyType;
  params.platform = platform;
  params.phoneNumber = phoneNumber;
  params.phonePlatform = phonePlatform;
  params.messengerUserId = messengerUserId;
  params.questionaryTargetExperience = targetExperience;
  params.conversionTest = appStorage.conversionTest;

  if(appStorage.bulkRoute == "true"){
    params.bulkRoute = "true";
  }

  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/createJobSeekerAccount.php';

  window.createJobseekerXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        //For tracking we need to know that a jobSeeker was created during this
        // session
        appStorage.newJobSeeker = "true";
        //Function if the account creation was a success
        successFunction(objResponse);
      } else {
        // Function if the account creation fail, cases might range from
        // the email already had an account attach to it, or there was a problem
        // with the database.
        failFunction(objResponse);
      }
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    },
    fail: function(){
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    }
  });

}

/**
 * Reset password email send for jobSeeker account with the given email, country and language
 * @param email             Email of the user
 * @param country           ISO (2 letters) for country EX: us,ca,gb
 * @param language          ISO (2 letters) for language EX: en,fr,ge
 * @param successFunction   Function if sending the email was successful
 * @param failFunction      Function if sending the email was not successful
 */

var resetPasswordSendEmailXHR = null;

function resetPasswordSendEmail(
    email,
    country,
    language,
    successFunction,
    failFunction,
) {
  // kill the any XHR request done before the must recent one
  if (window.resetPasswordSendEmailXHR) {
    window.resetPasswordSendEmailXHR.abort();
  }

  var params = {};
  params.email = email;
  params.country = country;
  params.language = language;
  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/sendEmailResetJobSeekerPassword.php';
  window.resetPasswordSendEmailXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        //Function if the email was send
        if (successFunction !== undefined)
          successFunction(objResponse);
      } else {
        // Function if the email was not success, might be because there is not
        // account attach to that email or it hits the limit of 3 emails per day
        // for account password reset request.
        if (failFunction !== undefined)
          failFunction(objResponse);
      }

    },
  });
}

/**
 * Reset user password giving 3 main elements, the user email, password and the
 * verification token.
 * @param email        Email of the user
 * @param token        Verification token for security reasons
 * @param password     New password of the user
 * @param country      ISO (2 letters) for country EX: us,ca,gb
 * @param language     ISO (2 letters) for language EX: en,fr,ge
 * @param successCode  Function if the password was updated
 * @param failFunction Function if the password was not updated
 */

var resetPasswordXHR = null;

function resetPassword
(
    userInfo,
    userToken,
    password,
    country,
    language,
    successCode,
    failFunction,
) {
  // kill the any XHR request done before the must recent one
  if (window.resetPasswordXHR) {
    window.resetPasswordXHR.abort();
  }

  var params = {};
  params.userInfo = userInfo;
  params.userToken = userToken;
  params.password = password;
  params.country = country;
  params.language = language;

  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/resetJobSeekerPassword.php';
  window.resetPasswordXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        // Function if updating the user's password was a success
        successCode(objResponse);
      } else {
        // Function if something fail updating the user's password
        // (must likely the security token given was expired)
        failFunction(objResponse);
      }

    },
  });
}

/**
 * Resend user's confirmation email with the code to activate the account
 * @param code
 * @param successFunction
 * @param failFunction
 */


function confirmJobSeekerEmail(code, successFunction, failFunction) {
  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }

  var params = {};
  params.code = code;
  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/confirmJobSeekerAccount.php';
  window.confirmJobSeekerEmailXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        // Function sending the email was a success
        successFunction(objResponse);
      } else {
        // Function if something fail trying to send the email, Ex: user already
        // verify or non-existent
        failFunction(objResponse);
      }
      $('.is--waiting').removeClass("is--waiting");
    },
    fail: function(){
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    }
  });
}

/**
 * Get an especifict history type of a user
 * @param type
 * @param successCode
 * @param failFunction
 */
var getUserHistoryXHR = null;

function getUserHistory(type, successCode, failFunction) {
  var params = {};
  params.type = type;

  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/getTypeHistory.php';
  window.getUserHistoryXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        // Function if that type of history is found
        successCode(objResponse);
      } else {
        // Function if the user does not have that type of history
        failFunction(objResponse);
      }

    },
  });
}

/**
 * Checks if the user profile is valid, and to be a valid profile, it needs
 * to have one Education entrie and one skill entrie
 * @param successFunction
 * @param failFunction
 */
var checkUserProfileXHR = null;

function checkUserProfile(successFunction, failFunction) {
  // kill the any XHR request done before the must recent one
  if (window.checkUserProfileXHR) {
    window.checkUserProfileXHR.abort();
  }

  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/validateUserProfile.php';

  window.checkUserProfileXHR = $.ajax({
    type: 'POST',
    url: where,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload.check;
      //Response routing
      if (objResponse.result == 'ok') {
        // Function if their profile is valid
        successFunction(objResponse);
      } else {
        // Function if their profile is not valid
        failFunction(objResponse);
      }

    },
  });
}

/**
 * This will re send the confirmation email for a log in jobSeeker
 */

function resendConfirmationCodeEmail() {

  var params = {};
  params.country  = domain.country;
  params.language = domain.language;
  var where = '/ajax/jobSeeker/resendConfirmCodeJobSeeker.php';

  $.post(where, params, function(response) {
    var objResponse = $.parseJSON(response);
    objResponse = objResponse.payload;
    $('.error-message[data-for=ConfirmForm]').text(objResponse.user_message);
    $('.error-message[data-for=ConfirmForm]').show();
    $('.error-message[data-for=ConfirmForm]').addClass('has--error');
    $('.error-message[data-for=ConfirmForm]').delay(1000 * 20).fadeOut(1000);
  });
}


/**
 * This will re send the SMS confirmation Text for SMS alerts
 */

function resendConfirmationCodeSMS () {

  var params = {};
  params.country  = domain.country;
  params.language = domain.language;
  var where = '/ajax/jobSeeker/resendSMSConfirmCode.php';

  $.post(where, params, function(response) {
    var objResponse = $.parseJSON(response);
    objResponse = objResponse.payload;
    $('.error-message[data-for=ConfirmForm]').text(objResponse.user_message);
    $('.error-message[data-for=ConfirmForm]').show();
    $('.error-message[data-for=ConfirmForm]').addClass('has--error');
    $('.error-message[data-for=ConfirmForm]').delay(1000 * 20).fadeOut(1000);
  });
}

/**
 *  This will update the user's history in different buckets
 *
 *  @param data object that contains the information that tye bucket needs
 *  one note if provided with a jobId it will get the job_title and job_location
 *  from that job.
 *
 *  @param type  The bucket type that want to be updated
 *  Ex: (bucket_name   -> key_input = key_value)
 *  job_click    -> jobId = jobid | keyword = job_title  | location = job_location
 *  job_ioa      -> jobId = jobid | keyword = job_title  | location = job_location
 *  job_favorite -> jobId = jobid | keyword = job_title  | location = job_location
 *  job_alert    -> keyword = user Input | location = user Input
 *  job_search   -> keyword = user Input | location = user Input
 *
 *  @param action if set to delete, it will delete the element on the selected
 *  bucket with the same key_values (Ex: in order to delete something from
 *  favorites it need type = job_favorite, data.jobid = asdf234 and action = delete
 *
 */
function userEventTracket(type, data, action) {

  var params = {};
  params.type = type;
  params.data = data;
  params.country = domain.country;
  params.language = domain.language;
  params.action = action;

  var where = '/ajax/jobSeeker/manageUserEvent.php';

  $.post(where, params, function(response) {
  });
}

/**
 * Function to update user events for multiple keywords
 * @param type  The bucket type that want to be updated
 *  Ex: (bucket_name   -> key_input = key_value)
 *  job_click    -> jobId = jobid | keyword = job_title  | location = job_location
 *  job_ioa      -> jobId = jobid | keyword = job_title  | location = job_location
 *  job_favorite -> jobId = jobid | keyword = job_title  | location = job_location
 *  job_alert    -> keyword = user Input | location = user Input
 *  job_search   -> keyword = user Input | location = user Input
 * @param data
 */
function multipleEventsUserTracker(type, data) {

  let params = {};
  params.type = type;
  params.data = data;
  params.country = domain.country;
  params.language = domain.language;

  let where = '/ajax/jobSeeker/manageMultipleUserEvents.php';

  $.post(where, params, function(response) {
  });
}

/**
 * General campaign popup it shows a image, header text, snippet and a CTA
 * @param campaign String: the name of the campaign EX: taxCal
 */
function showCampaignPopup(campaign = "") {
  // GeneralPopup location if empty generic transition popup is shown
  var where = '';
  if (campaign !== '') {
    where = '/ajax/generalUsePopups/generalPopup.php';
  } else {
    where = '/ajax/generalUsePopups/transitionPopup.php';
  }
  var params = {};
  params.language = domain.language;
  params.country = domain.country;
  params.campaign = campaign;
  params.device  = domain.device;
  // Sending the information to the popups
  $.get(where, params, function(response) {
    var objResponse = $.parseJSON(response);
    // we apprend the response to our general use popup
    hangElementToPopup(objResponse.payload.HTML);
  });
}

/**
 * For the capaign popup this will show the information with the given index
 * @param index int
 */

function displayPopupInfo(index) {
  $('.card--popup .isActive').removeClass('isActive');

  $('.popup__indexDot[data-index=' + index + ']').addClass('isActive');
  $('.popup__infoHolder[data-index=' + index + ']').addClass('isActive');
}

function nextInfo() {
  var index = $('.popup__infoHolder.isActive').attr('data-index');
  var nextPanel = parseInt(index) + 1;
  $('.card--popup .isActive').removeClass('isActive');

  if ($('.popup__indexDot[data-index=' + nextPanel + ']').length > 0) {
    $('.popup__indexDot[data-index=' + nextPanel + ']').addClass('isActive');
    $('.popup__infoHolder[data-index=' + nextPanel + ']').addClass('isActive');
  } else {
    closePopup();
  }

}

var timeout = '';

function UIShowWarning(elem) {
  if (window.timeout) {
    clearInterval(window.timeout);
  }
  var warningElem = $(elem).find('.input__disableMessage');
  warningElem.addClass('is--active');
  window.timeout = setInterval(function() {
    warningElem.removeClass('is--active');
  }, 3000);
}

/**
 * General cookies ToS popup
 * @returns {boolean}
 */
function getCookiesTosBanner() {

  if (getCookie('cookiesAccepted') === 'true') {
    return true;
  }

  var request = {};
  request.language = domain.language;
  request.languageFolder = domain.settings.langauge_folder;
  request.country = domain.country;

  var where = '/ajax/cookies-policy-html.php';

  $.get(where, request, function(response) {
    var objResponse = $.parseJSON(response);
    $('body').append(objResponse.payload.HTML);
  });
}

/**
 * If they accepts their cookies
 * @param elem
 */
function acceptCookies(elem) {
  elem.parentNode.parentNode.remove();
  setCookie('cookiesAccepted', 'true', 360);
}

/**
 * Multiplatform easy sign in, it will take the the information from uit and the
 * action to either create or login the user from a specific platform
 * @returns {string}
 */
function easySignIn() {
  //If there is no uit on the URL then there is nothing that we can do
  if (!getUrlVars()['uit']) {
    return '';
  }

  //Variables from the url
  var action = getUrlVars()['action'];
  var platform = getUrlVars()['platform'];
  var uit = getUrlVars()['uit'];
  var newRouting = getUrlVars()['newRouting'];

  // if there is a context we take that on the popup
  if (getUrlVars()['jobSeekerContext']) {
    appStorage.jobSeekerContext = getUrlVars()['jobSeekerContext'];
    if (appStorage.jobSeekerContext == 'apply') {
      appStorage.activeJobId = getUrlVars()['id'];
      appStorage.applyType = getUrlVars()['at'];
    }
    if (appStorage.jobSeekerContext == 'favorites') {
      appStorage.jobSeekerFavToAdd = getUrlVars()['id'];
    }
    if (appStorage.jobSeekerContext == 'serpBulkUsersPopUpJobClick') {
      appStorage.activeJobId = getUrlVars()['id'];
    }
    deleteStorageWhenLogin(appStorage.jobSeekerContext);
  }

  if (platform == '') {
    platform = 'talent';
  }

  // New routing is true, set the app storage to true
  // so we take the new routing path
  if (newRouting == 'true') {
    appStorage.newRouting = true;
    // If action is create call function to continue
    // the create account process
    if (action == 'create') {
      newRoutingCreateSSO();
    }
    // If action is login call function to continue
    // the login process
    if (action == 'login') {
      newRoutingLoginSSO();
    }
    return true;
  }

  //if the action is create then we show the create step popup but with some
  // modification like, we dont ask for a password and also there is no need
  // to confirm the user
  if (action == 'create' && getUrlSingleVar("np") == "true") {
    createEmailAlertWithSSO(uit,platform);
    return true;
  }

  if (action == 'create') {
    showJobSeekerPopup('createJobSeekerStep', getUrlVars()['id'], '',
        uit, platform);
  }
  // if the action to take is login or invalid_signin we call the easyLogIn process
  if (action == 'login') {
    if (appStorage.jobSeekerContext == 'apply') {
      //IF it is a quick apply job we need to check if the user's
      // have a CV or not
      if (appStorage.applyType == 'talentApply') {
        getUserStatus(function(response) {
          //If they do we don't ask for a CV on the application process
          if (response.hasCV == 'true') {
            routingApplyPopupProcess('false');
          } else {
            routingApplyPopupProcess('true');
          }
        });
      } else {
        //If it is not a quick apply job we just send then to the source
        sendToJobSource();
      }

    } else {
      routingEndPointAccountCreation('false');
    }
  }

  if (action == 'checkEmail') {
    appStorage.backupUit = uit;
    appStorage.backupPlatform = platform;
    showJobSeekerPopup('checkEmailStep', '', '',
        uit, platform);
  }

}

/**
 * New routing function to call the next popup in the create
 * account process when the account is created from SSO buttons
 */
function newRoutingCreateSSO(){
  showJobSeekerPopup('successConfirmation');
}

/**
 * New routing function to call the
 */
function newRoutingLoginSSO() {
  if (appStorage.jobSeekerContext == 'apply') {
    sendToJobSource();
  } else {
    newEndpointAccountCreation();
  }
}
/*
 * Delete the local storage whe the context login is different to Apply(applying to a job)
 * @param context It is the login context when the the user is login
 */
function deleteStorageWhenLogin(context){
  if(context != 'apply'){
    deleteLocalApplicationStorage();
  }
}

function createEmailAlertWithSSO(uit,platform){
  var params = {};
  params.uit = uit;
  params.platform = platform;
  params.country = domain.country;
  params.language = domain.language;
  params.jobSeekerContext = appStorage.jobSeekerContext;
  var where = "/ajax/jobSeeker/popups/accountCreationFlow/ajax/decodeSSOInfo.php";
  $.post(where, params, function (response) {
    var objResponse = $.parseJSON(response);
    appStorage.phoneOrMail = objResponse.payload.email;
    appStorage.email = objResponse.payload.email;
    appStorage.accountType = "sso";
    appStorage.midStep = "yes";
    // If the country has phone services, display the save phone number popup
    // The country of the user is stored using the geo when the account is created,
    // we check this value to see if the user's country is valid to send sms
    // in objResponse.isTheUserCountryValid
    if (!getUrlSingleVar("exist") &&
        objResponse.payload.isTheUserCountryValid && 
        appStorage.jobSeekerContext !== "accountGating") {
      showJobSeekerPopup("savePhoneStep");
    } else {
      if (appStorage.bulkRoute == "true") {
        routingEndPointAccountCreation();
      } else if(appStorage.jobSeekerContext == "accountGating"){
        routingEndPointAccountCreation();
      } else {
        showJobSeekerPopup("userSuccessfulConfirmation");
      }
    }

  })
}

/**
 * Load Job Posting Popups
 * Popups needed to complete the process of create account,
 * sign in, sms verification and reset password
 * @param url -----> (it can be sign-in, create-account)
 * @param userToken ---> the user token needed in the process
 * of sign in, create account and sms verification
 * @param accountId ---> account id linked to the user needed in the process of sms verification
 * @param url
 * @param userToken
 * @param accountId
 * @param additionalParams
 */
function loadJobPostingPopup(
    url = '',
    userToken = '',
    accountId = '',
    additionalParams,
) {
  // Required params
  var params = {};
  params.country = domain.country;
  params.language = domain.language;
  params.languageFolder = domain.settings.language_folder;
  params.device = domain.device;

  // Assign User token to params
  if (userToken !== '') {
    params.token = userToken;
  }

  // Assign account id to params
  if (accountId !== '') {
    params.aid = accountId;
  }

  // Assign additional params to
  // params for create account process
  if (additionalParams !== '') {
    params = Object.assign(params, additionalParams);
  }

  // job posting location files route
  var where = '/ajax/jobPosting/popup-' + url + '.php';
  // Sending the information to the popups
  $.get(where, params, function(response) {
    hangElementToPopup(response);
  });
}

/**
 * Popups used in the for employers landing page
 */
function redirectToEmployerPopup(success) {

  // SELECTORS

  let selectedOption = $('#company_type option:selected');

  let selected    = selectedOption.val();
  let companyType = selectedOption.attr('data-company_type');
  let companySize = selectedOption.attr('data-company_size');
  let employees   = selectedOption.attr('data-numemployees');
  
  // Switch to show the requested popup
  let url = '';
  switch (selected) {
    case 'talent-post':
      url = '/ajax/jobPosting/popup-create-user.php';
      break;
    case 'enterprise':
      url = '/ajax/for-employers/popup-contact-enterprise.php';
      break;
    case 'ats':
      url = '/ajax/for-employers/popup-contact-ats.php';
      break;
    default:
      url = '/ajax/for-employers/popup-select-company.php';
  }

  // Params to be send
  let params = {};
  params.country = domain.country;
  params.language = domain.language;
  params.selected = selected;
  params.companyType = companyType;
  params.companySize = companySize;
  params.numEmployees = employees;

  // Sending the information to the popups
  $.get(url, params, function (response) {
    hangElementToPopup(response);
  });
}

/**
 * 
 */
function submitEmployersContactForm(action) {
  
  // Kill the any XHR request done before the must recent one
  if (window.submitContactFormXHR) {
    window.submitContactFormXHR.abort();
  }

  let params = {};
  params.country = domain.country;
  params.language = domain.language;
  params.firstname = $('[name="firstname"]').val();
  params.lastname = $('[name="lastname"]').val();
  params.email = $('[name="email"]').val();
  params.phone = $('[name="phone"]').val();
  params.company = $('[name="company"]').val();
  params.company_type = $('[name="companyType"]').val();
  params.type_partnership_of_request = $('[name="partnership-type"]').val();
  params.region = $('[name="region"]').val();
  params.message = $('[name="message"]').val();
  params.contact___company_size = $('[name="companySize"]').val();
  params.numemployees = $('[name="numEmployees"]').val();
  params.token = $('[name="token"]').val();
  
  let where = '';
  if (action === 'ats') {
    where = '/ajax/for-employers/action/action-submit-ats.php';
  } else if (action === 'enterprise') {
    where = '/ajax/for-employers/action/action-submit-enterprise.php';
  }

  let isValid = true;
  let errors = "";
  
  // VALIDATE REQUIRED INPUTS
  $("form").find("input.required, select.required").filter(function() {
    let name = $(this).attr( "name" );
    errors = $('.error-message[data-for=' + name + ']');
    if ($(this).val().length === 0) {
      $(this).addClass('has--error');
      errors.addClass('has--error');
      isValid = false;
    }
  });
  
  if(!verifyEmail(params.email)){
    errors = $('.error-message[data-for=email]');
    $('[name="email"]').addClass('has--error');
    errors.addClass('has--error');
    isValid = false;
  }

  if (action === 'enterprise') {
    if (!params.phone.trim()) {
      errors = $('.error-message[data-for=phone]');
      $('[name="phone"]').addClass('has--error');
      errors.addClass('has--error');
      isValid = false;
    }
  }
  
  if (isValid) {
    window.submitContactFormXHR = $.ajax({
      type: 'POST',
      url: where,
      data: params,
      success: function (response) {
        let objResponse = $.parseJSON(response);

        // Response routing
        if (objResponse === true) {
          let parameters = {};
          parameters.country = domain.country;
          parameters.language = domain.language;
          parameters.device = domain.device;

          // Job posting location files route
          let file = '/ajax/for-employers/popup-success.php';

          // Sending the information to the popups
          $.get(file, parameters, function (resp) {
            hangElementToPopup(resp);
          });
        } else {
          // Iterate errors response to show red message
          for (const key in objResponse.errors) {
            let errorSelector = $(`.error-message[data-for=${objResponse.errors[key]}]`);
            errorSelector.addClass("has--error");
            // errorSelector.html(objResponse.errors[key]);
          }
        }
      },
    });
  }
}

/**
 * Talent post Logout
 */
function logoutTalentPost() {
  var where = '/employers/user/page-logout-post.php';
  $.get(where, '', function(response) {
    location.reload();
  });
}

/**
 * This will take the name and the value and add it to the url, while taking in
 * consideration of the URL have no, or some GET parameters on it
 * EX: /job?name=value or /job?page=1&name=value
 * @param string name
 * @param string value
 */
function replaceStateURL(name, value) {

  let link = window.location.href;
  let URLObject = new URL(link);
  let params = new URLSearchParams(URLObject.search.slice(1));

  params.set(name, value);
  link = '?' + params.toString();

  window.history.replaceState(null, null, link);
}

/**
 * This function checks if the user is coming from emails and if the interaction is
 * the personalize cta and redirects the user to the page, unless the user is logged in
 */
function userNotificationRedirect() {
  var get_params = getUrlVars();
  if (domain.jobSeekerLogin != 1 && (get_params.source == 'emails' || get_params.source == 'talent-email') && get_params.templateId && get_params.endpoint == 'notifications') {
    appStorage.jobSeekerUserPage = get_params.endpoint;
    showJobSeekerLogIn('user-page');
  }
}

function RadiusUncheck() {
  // iterate using Array method for compatibility
  Array.prototype.forEach.call(document.querySelectorAll('[type=radio]'),
      function(radio) {
        if (radio.dataset.event) {
          return true;
        } else {
          radio.setAttribute('data-event', 'true');
        }
        radio.addEventListener('click', function() {
          var self = this;
          // get all elements with same name but itself and mark them unchecked
          Array.prototype.filter.call(document.getElementsByName(this.name),
              function(filterEl) {
                return self !== filterEl;
              }).forEach(function(otherEl) {
            delete otherEl.dataset.check;
          });

          // set state based on previous one
          if (this.dataset.hasOwnProperty('check')) {
            this.checked = false;
            delete this.dataset.check;
          } else {
            this.dataset.check = '';
          }
        }, false);
      });
}

/**
 * This function checks if the user is coming from emails and if the interaction is
 * the personalize cta and redirects the user to the page, unless the user is logged in
 */
function userSuccessConfirmationPopup() {
  var get_params = getUrlVars();
  if (get_params.emailConfirmation == 'ok') {
    appStorage.jobSeekerContext = get_params.context;
    showJobSeekerPopup('userSuccessfulConfirmation', '', '');
  }
}

/**
 * This function is in charge to decide the action of the CTA in the user confirmation popup
 * according to the context for the user when registered
 */
function userConfirmationRedirect() {

  if (getUrlSingleVar('emailConfirmation') != '') {
    // Get parameters
    var get_params = getUrlVars();
    appStorage.activeJobId = get_params.id;
    appStorage.jobSeekerContext = get_params.context;
    appStorage.jobSeekerFavToAdd = get_params.id;
    // get_params.emailConfirmation = "";
    replaceStateURL('emailConfirmation', '');
    routingEndPointAccountCreation();
  } else {
    routingEndPointAccountCreation();
  }

}

function callMaskJS() {
  var s = document.createElement('script');
  s.type = 'text/javascript';
  s.src = domain.objCDN + '/libs/js/jquery.mask.js';
  // Use any selector
  $('head').append(s);

  // This is a custom version of the InputMask.js that contains
  // The dates extensions to validate inputs
  const inputMask = document.createElement('script');
  inputMask.type = 'text/javascript';
  inputMask.src = domain.objCDN + '/libs/js/inputmask-js/5.0.7/input-mask.js';
  // Use any selector
  $('head').append(inputMask);

}

/**
 * Controls the hide/show actions in the dropdown links on the mobile menu from Enterprise pages
 * Used in the ui_menu class
 * @param string DOM element attached
 */
function toggleDropdownLink(element) {
  let dropdownHolder = $(element).
      parent().
      find('.menu__dropdownHolder.menu__dropdownLink-content');

  $(element).toggleClass('menu__highlighted');

  if ($(dropdownHolder).hasClass('hide')) {
    $(dropdownHolder).slideDown();
    $(dropdownHolder).removeClass('hide');
  } else {
    $(dropdownHolder).slideUp();
    $(dropdownHolder).addClass('hide');
  }
}

/**
 * General label toolTip popup class manager to display it
 * @param name
 */
function toggleToolTIp(name) {
  //We use the name to find the element
  // to be toggle and add the class 'is--active'
  $('.tooltip--content[data-for=' + name + ']').toggleClass('is--active');
}

/**
 * Shows users that came from home page with the specific action
 * the user create step popup
 */
function showCreatePopupFromHomeRedirect() {
  //Only do this if we don't come from SSOS
  if (getUrlVars()['uit']) {
    return '';
  }
  if (domain.forceRegistration.toLocaleLowerCase() == 'usercreatefromhome' &&
      domain.jobSeekerLogin === '0') {
    appStorage.jobSeekerContext = 'homeRedirect';
    showJobSeekerPopup('checkEmailStep');
  }
}

/**
 *  This function shows the pop-up to enter the confirmation code
 *  and sends the email with the code.
 */
function clickUnconfirmedMenuOption() {
  showJobSeekerPopup('confirmCodeStep');
  resendConfirmationCodeEmail();
}

/**
 * Loads scripts async
 * @param url File url locations
 * @param callback function for success call
 */
function callJSFile (url, callback) {
  jQuery.ajax({
    url: url,
    dataType: 'script',
    success: callback,
    async: true
  });
}


/**
 * Send a fetch request
 * @param where File url path
 * @param method HTTP request method
 * @param params Data to send in the request
 * @param successCallback function for success call
 */
function doFetchRequest(where, method, params, successCallback = null) {

  if (!(params instanceof FormData)) {
    //If the params are into an object, It is parsed to formdata object
    params = convertObjectToFormData(params)
  }

  fetch(where,
      {
        method: method,
        body  : params
      }
  )
      .then((response) => {
        return response.json();

      })
      .then((finalResponse) => {
        if (successCallback) {
          successCallback(finalResponse)
        }

      })
      .catch(error => {
        return error;
      })

  return {result: 'ok'}
}


/**
 * Convert a object to form data structure
 * @param objectParams Object data
 */
function convertObjectToFormData(objectParams) {
  let formData = new FormData();

  // Loop by every field into the object
  for (let key in objectParams) {
    formData.append(key, objectParams[key]);
  }

  return formData;
}

/**
 * Activates the autocomplete functionality on the location for the account
 * creation process based on the country and laguagne given
 * @param country String 2 letter ISO format country
 * @param langauge 2 letter ISO format language
 */
function enableAutoCompleteLocationOnAccountProcess(country, langauge) {

  // Auto complete for location
  $('#locationCreate').autocomplete({
    serviceUrl: '/ajax/auto-suggest.php?type=location&country=' +
        country + '&language=' + langauge,
    triggerSelectOnValidInput: false,
    onSelect: function(value, data) {
    },
  });

}

/**
 * Closes the popup when the user tries to perform "Go back to previous page"
 * button interactions.
 */
function closePopupOnGoBackAction() {
  history.pushState(null, null, location.href);
  window.onpopstate = function () {
    closePopup();
  };
}

/**
 * generateWysiwygApply
 * Function to render all the Wysiwyg (textarea question in popup for extra question)
 * @param id Unique id to generate the wysiwyg
 * @param placeholder Placeholder of Wysiwyg
 * @param height height of the Wysiwyg
 * @param maxHeight Max height define for the Wysiwyg, if set the auto resize plugging will be add it
 */
function generateWysiwygApply(id, placeholder, height, maxHeight = '') {

  // Auto resize plugging needed to grow the wysiwyg until
  // the limit of max height is reach
  var autoResize = ",";
  if (maxHeight) {
    autoResize = ',autoresize,';
    var max_height = maxHeight;
  }

  tinymce.init({
    selector: '#' + id,
    plugins: 'lists,paste, wordcount' + autoResize,
    'toolbar': 'bullist bold italic underline',
    placeholder: placeholder,
    paste_enable_default_filters: false,
    paste_as_text: true,
    resize: false,
    elementpath: false,
    menubar: false,
    branding: false,
    height: height,
    min_height: height,
    max_height: max_height,
    statusbar: false,
    force_p_newlines : false,
    force_br_newlines : true,
    convert_newlines_to_brs : false,
    remove_linebreaks : true,
    entity_encoding : "raw",
    content_css: [
      '//fonts.googleapis.com/css?family=Poppins:300,400,500,600&amp;subset=latin,greek-ext,vietnamese,' +
      'cyrillic-ext,latin-ext,cyrillic',
      '/public/assets/css/tinyMCE/tinyMCE-editor.css?' +
      new Date().getTime()],
    paste_auto_cleanup_on_paste : true,
    paste_postprocess : function(plugin, args) {

      let targetId        = args.target.id;
      let maxLength       = parseInt(document.getElementById(targetId).getAttribute('maxlength'));

      if (maxLength) {
        let editorCount     = tinymce.get(targetId).plugins.wordcount;
        let charCount       = parseInt(editorCount.body.getCharacterCount());

        // Count line breaks
        let enter = tinymce.get(targetId).contentDocument.querySelectorAll('br').length - 1;
        charCount += !((maxLength - charCount) > 0) ? enter : 0;

        let pastedContent   = args.node.innerText;

        if ((maxLength - charCount) > 0) {
          let differenceCount = maxLength - charCount;
          pastedContent       = pastedContent.substring(0, differenceCount);
          args.node.innerHTML = pastedContent;
        } else {
          args.stopImmediatePropagation();
          args.stopPropagation();
          args.preventDefault();
        }
      }
    },
    setup: function(editor) {
      // Stop writing when reach limit
      var maxlength = parseInt($('#' + (id)).attr('maxlength'));
      editor.on('keydown', function(e) {
        // Selectors
        let wordCount = tinymce.get(id).plugins.wordcount;
        tinymce.triggerSave();
        // Defining the words to count without including enter and delete keys
        let words = wordCount.body.getCharacterCount();

        // Count line breaks
        let enter = tinymce.get(id).contentDocument.querySelectorAll('br').length - 1;
        words += enter;

        if ((words >= maxlength) && (e.keyCode != 8 && e.keyCode != 46)) {
          e.stopPropagation();
          return false;
        }
      });
      editor.on('keyup', function() {
        countTextAreaCharacter(this);
      });
      editor.on('change', function () {
        tinymce.triggerSave();
        countTextAreaCharacter(this);
      });
    }
  });
}

/**
 * Counts the amount of characters in a textarea element and displays it
 * in a label. If the label does not exists, it will not be executed
 * @param elem
 */
function countTextAreaCharacter(elem) {

  elem                = elem.targetElm;
  let textCountLabel  = document.getElementById('textCount-' + elem.id);

  if (textCountLabel) {
    let maxLength       = document.getElementById(elem.id).getAttribute('maxlength');
    let wordCountPlugin = tinymce.get(elem.id).plugins.wordcount;
    let characterCount  = wordCountPlugin.body.getCharacterCount();

    // Count line breaks
    let enter = tinymce.get(elem.id).contentDocument.querySelectorAll('br').length - 1;
    characterCount += enter;

    if (textCountLabel && maxLength) {
      maxLength                 = parseInt(maxLength);
      textCountLabel.innerHTML  = maxLength - characterCount;

      //if already exceeds the limit, we try to delete the "." and space that is the problem with mac
      if ( maxLength - characterCount < 0) {
        //get the content
        let text = tinymce.get(elem.id).getContent({format : 'raw'});
        //Remove the . and space added
        text = text.replace('.&nbsp;','');
        text = text.replace('. ','');
        //Set the new content
        tinymce.get(elem.id).setContent(text);
      }

      if (maxLength - characterCount < 6) {
        textCountLabel.style.color = 'red';
      } else {
        textCountLabel.style.color = '#676767';
      }
    }
  }

};


/**
 * Toggle accordion extra questions
 * This function close and open the preview accordion
 * with all the questions answered
 */
function toggleExtraQuestions(elem) {
  // Selectors
  let box   = $(elem).next('.card--profileInfo__question-box');
  let arrow = $('.card--profileInfo__info--arrow');

  // If the box container is close --> open
  if (box.is(':hidden')) {
    box.slideDown(300);
    arrow.addClass('card--profileInfo__info--arrow-flip');
  } else {
    // If the box container is open --> close
    box.slideUp(300);
    arrow.removeClass('card--profileInfo__info--arrow-flip');
  }
}


/**
 * Get the json extra question from local storage
 * Recuperate the values using the job id set in url
 * The Local storage will be set using the job id as soon as the user stars
 * answering questions
 */
function getSessionApplication() {
  // Use the id of the job to get the application from storage
  var storageKey = 'application' + appStorage.activeJobId;
  if (localStorage.getItem(storageKey)) {
    return JSON.parse(localStorage.getItem(storageKey));
  } else {
    // Return false if there is not json in local storage
    return false;
  }
}

/**
 * Function to get the values of the jobseeker applciation from Json
 * @param json
 * @returns {string}
 */
function getUserInfoInJson(json) {

  var found = {};
  // Iterate through the json
  $.each(json, function(keyword, value) {
    // Add only if the name is not empty (extra questions may not have a name)
    if(value.name != ""){
      // Exception to add the cv_id and cv_name to the final object
      if(value.name == "cv_id"){
        found['cv_id'] = value.cv_id
        found['cv_name'] = value.response;
      }else{
        found[value.name] = value.response;
      }
    }
  });
  return found;
}

/**
 * Function to find the email value store in json
 * @param json
 * @returns {string}
 */
function getEmailInJson(json) {
  var found = "";
  $.each(json, function(keyword, value) {
    if (value.name === "email") {
      found = value.response;
    }
  });
  return found;
}

/**
 * Check if an email have an jobSeeker account attach to it
 * @param email         Email of the user we want to check
 * @param successFunction    Function if the user have an account
 * @param failFunction      Function if user does not have an account
 * @param isNotValidEmailDomainFunction Function if user enters an invalid domain
 */
var newCheckAccountXHR = null;

function newCheckAccount(emailOrPhone, successFunction, failFunction, isNotValidEmailDomainFunction = () => void 0) {
  // Kill the any XHR request done before the must recent one
  if (window.checkAccountXHR) {
    window.checkAccountXHR.abort();
  }

  var params = {};
  params.emailOrPhone = emailOrPhone;
  params.country      = domain.country;
  // Ajax file location, eveything JobSeeker related is on the /jobSeekerFolder
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/checkJobSeekerAccount.php';
  // Storing the XHR request if there is a need for killing it because of a
  // new request. So we garantee to send the must recent information.
  window.newCheckAccountXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      // Response routing
      if (objResponse.response == 'account') {
        // Excecute the success function if we detect that the user haves
        // an account with that email
        successFunction(objResponse);
      } else if (objResponse.response == 'invalid email domain') {
        // Execute the not valid email domain function when the
        // domain is not valid
        isNotValidEmailDomainFunction(objResponse);
      } else {
        // Excecute the fail function if we detect that the user does not have
        // an account with that email
        failFunction(objResponse);
      }
    },
  });
}

/**
 * Generate OTP Code for email accounts
 * @param email             Email of the user we want to send the code
 * @param successFunction   Function if the user have an account
 * @param failFunction      Function if user does not have an account
 */
var otpEmailXHR = null;

function sendOTPCodeEmail(email, length, successFunction, failFunction) {
  // Kill the any XHR request done before the must recent one
  if (window.otpEmailXHR) {
    window.otpEmailXHR.abort();
  }

  var params = {};
  params.email    = email;
  params.length   = 6;
  params.source   = (appStorage.applyType) ? 'apply_otp': 'otp_code';
  params.country  = domain.country;
  params.language = domain.language;
  params.accountExist = appStorage.accountExist;

  // Ajax file location to generate and send the OTP code
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/generateEmailOTPcode.php';

  // Storing the XHR request if there is a need for killing it because of a
  // new request. So we garantee to send the must recent information.
  window.otpEmailXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      // Response routing
      if (objResponse.response == 'sent') {
        // Excecute the success function if we have sent the email to the user
        successFunction(objResponse);
      } else {
        // Excecute the fail function if we detect that the email couldn't be
        // sent
        failFunction(objResponse);
      }
    },
  });
}


/**
 * Generate OTP Code for phone number accounts
 * @param phone             Phone of the user we want to send the code
 * @param successFunction   Function if the user have an account
 * @param failFunction      Function if user does not have an account
 */
var otpPhoneXHR = null;

function sendOTPCodePhone(phone, length, successFunction, failFunction) {

  // Kill the any XHR request done before the must recent one
  if (window.otpPhoneXHR) {
    window.otpPhoneXHR.abort();
  }

  var params = {};
  params.phone    = phone;
  params.length   = length;
  params.country  = domain.country;
  params.language = domain.language;
  params.accountExist = appStorage.accountExist;

  // Ajax file location to generate and send the OTP code
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/generatePhoneOTPcode.php';

  // Storing the XHR request if there is a need for killing it because of a
  // new request. So we garantee to send the must recent information.
  window.otpPhoneXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      // Response routing
      if (objResponse.response == 'sent') {
        // Excecute the success function if we have sent the email to the user
        successFunction(objResponse);
      } else {
        // Excecute the fail function if we detect that the email couldn't be
        // sent
        failFunction(objResponse);
      }
    },
  });
}



/**
 * Send user's confirmation email with the OTP code to activate the account
 * @param code digit code (can be 4 or 6)
 * @param successFunction
 * @param failFunction
 */
function confirmJobSeekerPhoneByOTP(code, phone, length, successFunction, failFunction) {
  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }
  var params      = {};
  params.code     = code;
  params.phone    = phone;
  params.length   = length;
  params.country  = domain.country;
  params.language = domain.language;
  params.jobSeekerContext = appStorage.jobSeekerContext;
  params.jobSeekerPath    = appStorage.accountType;
  params.activeJobId = appStorage.activeJobId;
  params.applyType = appStorage.applyType;
  params.isBulk = appStorage.bulkRoute;

  // Ajax file location
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/confirmPhoneByOTP.php';
  window.confirmJobSeekerPhoneXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        // Function sending the email was a success
        successFunction(objResponse);
      } else {
        // Function if something fail trying to send the email, Ex: user already
        // verify or non-existent
        failFunction(objResponse);
      }
      $('.is--waiting').removeClass("is--waiting");
    },
    fail: function(){
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    }
  });
}

/**
 * Send user's confirmation email with the OTP code to activate the account
 * @param code 4 digit code
 * @param successFunction
 * @param failFunction
 */
function confirmJobSeekerEmailByOTP(code,email,lenght, successFunction, failFunction) {
  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }

  // kill the any XHR request done before the must recent one
  if (window.confirmJobSeekerEmailXHR) {
    window.confirmJobSeekerEmailXHR.abort();
  }

  var params      = {};
  params.code = code;
  params.email = email;
  params.lenght = lenght;
  params.country = domain.country;
  params.language = domain.language;
  params.jobSeekerContext = appStorage.jobSeekerContext;
  params.accountGatingKeyword = appStorage.accountGatingKeyword;
  params.jobSeekerPath = appStorage.accountType;
  params.activeJobId = appStorage.activeJobId;
  params.applyType = appStorage.applyType;
  params.otpSkip = appStorage.otpSkip;
  params.isBulk = appStorage.bulkRoute;
  params.click_id = getUrlVars()['click_id'];
  params.pbc_id = getUrlVars()['pbc_id'];
  params.id = getUrlVars()['id'];
  // Validate the app exist and we have the page type set
  if (typeof app === 'object' && app.pageName !== undefined) {
    params.pagetype = app.pageName;
  }

  // todo
  if (appStorage.jobSeekerContext == "apply" && appStorage.flow == "talentApplyOtp") {

    var questions = getSessionApplication();
    var user = getUserInfoInJson(questions);

    params.firstName = user.first_name;
    params.lastName = user.last_name_raw;
    params.cv_id = user.cv_id;
    params.cv_name = user.cv_name;
    params.emailAllow = '1';
  }

  if(appStorage.jobSeekerContext == "accountGating") {
    params.emailAllow = '0';
  }

  if(sessionStorage.keywords !== undefined){
    params.keywords = sessionStorage.keywords;
  }

  if (appStorage.jobSeekerContext == "spa-mbg") {
    params.l_mbg = appStorage.l_mbg;
    params.k_mbg = appStorage.k_mbg;
    params.suggested_mbg = appStorage.suggested_mbg;
    params.page_mbg = (window.location.pathname.split("/").pop()).replace('.php', '');
  }

  // Ajax file location
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/confirmEmailByOTP.php';
  window.confirmJobSeekerEmailXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        // Function sending the email was a success
        successFunction(objResponse);
      } else {
        // Function if something fail trying to send the email, Ex: user already
        // verify or non-existent
        failFunction(objResponse);
      }
      $('.is--waiting').removeClass("is--waiting");
    },
    fail: function(){
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    }
  });
}


/**
 * This function decides the behaviour of the skip button
 */
function skipAlertRouter(){

  if(appStorage.jobSeekerContext == 'jobsOrganicStrategy'){
    var eventData = {}
    eventData.jobseeker_context = appStorage.jobSeekerContext;
    eventData.bulk_strategy = appStorage.bulkRoute;
    sendEventToUET("closePopup",eventData);
  }

  if(appStorage.jobSeekerContext == 'job_swipe_skip'){
    var eventData = {}
    eventData.jobseeker_context = appStorage.jobSeekerContext;
    sendEventToUET("skipJobSwipe",eventData);
    appStorage.bulkLog = "yes";
    loadNextJobAllowSkip($(".button--secondary"), "yes", "jobsense", "JobHeaderSwipeAllowSkip");
  }

  if(appStorage.jobSeekerContext == "bulk_view_description") {
    closePopup();
    showHideDescription(appStorage.activeJobId);
    return true;
  }

  if(appStorage.jobSeekerContext == "apply" && appStorage.midStep != "yes"){
    sendToJobSource();
  }else if (appStorage.jobSeekerContext == "salaryWhitepageWidget"){
    // Add the language folder to this variable and check if its undefined
    var languageFolder = domain.settings.language_folder;

    // If its undefined, leave it blank
    if (languageFolder == undefined) {
      languageFolder = "";
    }

    window.location.href = languageFolder + "/salary?job="+app.jobTitle;
  }else{
    if (appStorage.midStep == "yes") {
      if(appStorage.bulkRoute == "true"){
        routingEndPointAccountCreation();
      }else{
        showJobSeekerPopup("userSuccessfulConfirmation");
      }
    } else {
      closePopup();
    }

  }
}

/**
 * Takes the email input from the check user step and
 * if they don't have a jobSeeker account, we promnt that view
 * if they do we ask then to log in.
 */
function applyByEmailOrPhoneStep() {

  // Email or Phone Value
  var phoneOrMail = $(event.target).find('input[type=email]').val().trim();
  var isValid = false;
  var OTPLenght  = 6;
  var route = "";
  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }

  // Save phone for next steps
  appStorage.phoneOrMail = phoneOrMail;

  var valueType = "email";

  // Check if the email is correct, if it not correct we show then an error message
  if (verifyEmail(phoneOrMail)) {
    // Save the account type
    appStorage.accountType = "email";
    appStorage.email = phoneOrMail;
    isValid = true;
  } else {
    if (valueType === "email" || appStorage.accountType === "sso") {
      $(event.target).find('input[type=email]').addClass('has--error');
      $(event.target).find('.error-message').addClass('has--error');
      $('.is--waiting').removeClass("is--waiting");
        return true;
    }
  }

  // Check if the country has phone services first then
  // Check if the phone is correct, if it not correct we show then an error message
  if (domain.allowSMSandWA != "") {
    if (verifyPhone(phoneOrMail)) {
      // Save the account type
      appStorage.accountType = "phone";
      appStorage.phone = phoneOrMail;
      isValid = true;
    } else {
      if (valueType == "phone") {
        $('input[name=phoneOrMailCheck]').addClass('has--error');
        $('.error-message[data-for=phoneOrMailCheck]').addClass('has--error');
      }
    }
  }

  //if the input is valid either as an email or phone number we check if there is
  //an accoutn attach to that input
  if(isValid){
    // Check the user's account
    newCheckAccount(phoneOrMail,function(response) {
      // Case when is already an user
      //If the user does not have a password and they need an OTP then
      if (response.password_type == "otp") {
        route = 'signInJobSeekerStepOTP';
        // If the account is a phone based account
        if(appStorage.accountType == 'phone'){
          // Send the OTP code for phone based accounts
          sendOTPCodePhone(phoneOrMail,OTPLenght,function(){},function(){});
        }else{
          // Send the OTP code for email based accounts
          sendOTPCodeEmail(phoneOrMail,OTPLenght,function(){},function(){});
        }
      }
      // case the type of account has a legacy password (old accounts)
      else if(response.password_type == "legacy"){
        // Check the type of the account
        if (appStorage.accountType == 'phone') {
          route = "signInJobSeekerStepOTP";
          // Send the OTP code to the phone
          sendOTPCodePhone(phoneOrMail,OTPLenght,function(){},function(){});
        } else {
          // If is not a phone based account show the sign in popup
          // route = "legacySignInJobSeekerStep";
          showJobSeekerPopup("signInJobSeekerStep","","","","",true);
        }
      } else {
        // Default behaviour show the jobseekers sign in popup
        route = "legacySignInJobSeekerStep";
        showJobSeekerPopup("signInJobSeekerStep","","","","",true);
        return true;
      }

      // Flag to determine if the user is loggin in via OTP or Legacy
      appStorage.isLogginIn = "yes";

      // Read the correct route to log in the user according to the type of account
      showJobSeekerPopup(route);
      $('.is--waiting').removeClass("is--waiting");
    },function(){
      // Case when we create a new user
      route = 'verifyStep';
      // Case when the account type is a phone type
      if(appStorage.accountType == 'phone'){
        // Send OTP code to the phone based accounts
        sendOTPCodePhone(phoneOrMail,OTPLenght,function(){},function(){});
      }else{
        // Send OTP code to the email based accounts
        // Autoconfirm the account for Organic Bulk Strategy - Check if the country can skip this step
        if (domain.otpSkippedCountry == "1" && appStorage.otpSkip == "yes") {
          confirmPhoneOrEmailAccount(); return false;
        } else {

          // New Account Gating Process requires to set first a keyword before sending the email
          if (appStorage.jobSeekerContext == 'accountGating' && domain.device == 'mobile') {
              showJobSeekerPopup('verifyStep');
              return false;
          }

          if(appStorage.newRouting == true){
            showJobSeekerPopup('verifyEmailStep');
            return false;
          }

          sendOTPCodeEmail(phoneOrMail,OTPLenght,function(){},function(){});

          // If the context is "bulk_email_widget", redirect the user to the routingEndPointAccountCreation
          if (appStorage.jobSeekerContext == "bulk_email_widget") {
            routingEndPointAccountCreation(); return false;
          }

        }
      }
      // Display the correct route
      showJobSeekerPopup(route);
      $('.is--waiting').removeClass("is--waiting");
    }, function () {
      $('input[name=phoneOrMailCheck]').addClass('has--error');
      $('.error-message[data-for=phoneOrMailCheck]').addClass('has--error');
      $('.is--waiting').removeClass("is--waiting");
    });
  } else {
    // Showing error message if the email was not a valid one
    $('input[name=emailCheck]').addClass('has--error');
    $('.error-message[data-for=emailCheck]').addClass('has--error');
    $('.is--waiting').removeClass("is--waiting");
  }
}


/**
 * confirmPhoneOrEmailAccount()
 * Check if the account is email base or phone base, and gets their code and
 * compared to the backend. This function is used in the popups to confirm the
 * email or the phone.
 */
function confirmPhoneOrEmailAccount() {
  // Disable button
  // Account creation flag
  appStorage.accountCreation = 'yes';

  // Inputs from the popup
  var phoneOrEmail = appStorage.phoneOrMail;
  var code  = $('input[name=confirmCode]').val();

  // isValid default value if true, if one of the inputs is wrong, this value will
  // change to false.
  var isValid = true;

  // Only for SSO accounts
  if (appStorage.accountType == 'sso') {
    phoneOrEmail = appStorage.phone;
  }

  // Clean previous error messages
  $('.has--error').removeClass('has--error');

  // If its all good we send the form
  if (isValid) {
    if (appStorage.accountType == 'email') {
      // We confirm the email account
      confirmJobSeekerEmailByOTP(code,phoneOrEmail,6,function(response) {
        let otpParams = {};
        otpParams.eventName = "apply_otp_submission";
        otpParams.step      = "apply_otp_submission";
        registerEventApply(otpParams);
        if(appStorage.jobSeekerContext == "apply" && appStorage.flow == "talentApplyOtp"){
          routingEndPointAccountCreation();
          return true;
        }
        // If the account is confirmed, add the midstep variable
        appStorage.midStep = "yes";
        // If the country has SMS or WhatsApp services Enabled, display the
        // savePhoneNumber popup
        if (appStorage.jobSeekerContext === "spa-mbg") {
          if (appStorage.country === "us" || appStorage.country === "ca") {
            showJobSeekerPopup("savePhoneStep");
          } else {
            if (appStorage.bulkRoute === 'true') {
              appStorage.accountConfirmed = 'yes';
              routingEndPointAccountCreation();
            } else {
              showJobSeekerPopup('userSuccessfulConfirmation');
            }
          }
        } else if (appStorage.jobSeekerContext == "accountGating") {
            showJobSeekerPopup("successConfirmation"); return false;
        } else if (appStorage.jobSeekerContext != "bulk_email_widget" && response.isTheUserCountryValid) {
          if(appStorage.newRouting == true){
            showJobSeekerPopup("selectCategory");
          }else{
            showJobSeekerPopup("savePhoneStep");
          }

        }
        // If the country doesn't have phone services, display the sucess message
        else {
          // Push Notification Show Popup during User Creation process
          // When the user tries to create an account in UK, we display the push
          // notifications step first.
          /*
          if (domain.allowPushNotification == "1" &&
              appStorage.bulkRoute == "true" &&
              appStorage.isPushNotificationPopupShown != 'yes' &&
              appStorage.jobSeekerContext != 'salaryWhitepageWidget'
          ) {
            var route = "popupPushNotification";

            // If the user doesn't allow notifications then change the route
            if (Notification.permission == "denied") {
              route = "userSuccessfulConfirmation";
            }
            saveNotificationDefaultStatus(Notification.permission);

            appStorage.isPushNotificationPopupShown = 'yes';
            showJobSeekerPopup(route);
          }
          */
            if (appStorage.bulkRoute == 'true') {
              appStorage.accountConfirmed = 'yes';
              routingEndPointAccountCreation();
            } else {
              showJobSeekerPopup('userSuccessfulConfirmation');
            }
        }
      },function() {
        // Display errors if it cannot be confirmed
        $('input[name=confirmCode]').addClass('has--error');
        $('.error-message[data-for=errorConfirm]').addClass('has--error');
      })
    } else {
      // We confirm the phone number account
      confirmJobSeekerPhoneByOTP(code,phoneOrEmail,4,function(){
        let otpParams = {};
        otpParams.eventName = "apply_otp_submission";
        otpParams.step      = "apply_otp_submission";
        registerEventApply(otpParams);
        // If the account is confirmed, add the midstep variable
        appStorage.midStep = "yes";
        // If the type of account is SSO show the successful confirmation
        if (appStorage.accountType == 'sso') {
          showJobSeekerPopup("userSuccessfulConfirmation");
        } else {
          // If the type of account is phone number based, show the save email step
          showJobSeekerPopup("saveEmailStep");
        }
      },function(){
        // Display errors if none of the paths could be choose.
        $('input[name=confirmCode]').addClass('has--error');
        $('.error-message[data-for=errorConfirm]').addClass('has--error');
      })
    }
  }
}

/**
 * This function will create the event apply_otp_submission
 * Track is in /ajax/applyProcess/registerApplyEvents.php
 *
 *
 */
function registerEventApply(params) {
  let fd    = new FormData();
  let where = '/ajax/applyProcess/registerApplyEvents.php';

  let action = "";
  let email  = appStorage?.email ? appStorage?.email : appStorage?.phoneOrMail;
  if (appStorage.applyStep == "verifyEmailStep") {
    action = "create_account"
  } else if (appStorage.applyStep == "signInOTPEmail") {
    action = "login";
  }

  // Load all parameters to the form data
  fd.append('step', params.step);
  fd.append('event', params.eventName);
  fd.append('country', domain.country);
  fd.append('language', domain.language);
  fd.append('cta_position', params.cta_position);
  fd.append('isLogginIn', !!appStorage.isLogginIn);
  fd.append('card_position', params.card_position);
  fd.append('page_number', params.page_number);
  fd.append('job_attribute_apply', params.job_attribute_apply);
  fd.append('job_attribute_salary', params.job_attribute_salary);
  fd.append('job_attribute_remote', params.job_attribute_remote);
  fd.append('job_attribute_new_job', params.job_attribute_new_job);
  fd.append('job_attribute_promoted', params.job_attribute_promoted);
  fd.append('job_attribute_job_type', params.job_attribute_job_type);

  if (params.jobid) {
    fd.append('jobid', params.jobid);
  } else if (appStorage.activeJobId) {
    fd.append('jobid', appStorage.activeJobId);
  }

  if (action) {
    // Only actions related to apply will generate this event
    fd.append('action', action);
    // fd.append('result', result);
  }

  if (email) {
    fd.append('email', email);
  }

  fd.append('questions_panel', params.questions_panel);
  if (params?.questions_panel) {
  }

  if (appStorage?.easy_apply) {
    fd.append('easy_apply', appStorage.easy_apply);
  }

  // Apply middleman location
  fetch(where, {method: 'POST', body: fd})
      .then((response) => {
        return response.text();
      })

}

/**
 * storePhoneOrEmailExtraAlert()
 * This function belongs to the second step for the account creation or login
 * process. It is used in the popups to save the phone number or the email account
 * depending on the flow that the user chooses.
 */
function storePhoneOrEmailExtraAlert(){

  // Clear all previous error messages
  $('.error-message[data-for=errorConfirm]').removeClass('has--error');
  $('.error-message[data-for=extraPhone]').removeClass('has--error');
  $('.error-message[data-for=extraEmail]').removeClass('has--error');

  // Flag to check wether if an account exists or not for the second step
  appStorage.accountExist = 0;

  // Unless the country is allowed to have SMS or WhatsApp services, don't store
  // extra data
  if (domain.allowSMSandWA != "") {
    // Check the email account type or if it is a SSO account
    if(appStorage.accountType == "email" || appStorage.accountType == "sso"){
      // Get the phone value from the input
      var phone = $('input[name=extraPhone]').val().trim();
      // Verify the phone
      if(verifyPhone(phone)){
        // Check the user account if it exists
        newCheckAccount(phone,function(response){
          // If the response is account the account exits, send a 6 digits otp code
          if (response.response == "account") {
            appStorage.phone = phone;
            appStorage.secondStepLoginData = phone;
            appStorage.secondStepLoginType = "phone";
            appStorage.accountExist = 1;
            sendOTPCodePhone(phone,6,function(){},function(){})
            showJobSeekerPopup("signInJobSeekerStepOTPPhone");
          } else {
            // if we have another response, display error messages
            $('.error-message[data-for=errorConfirm]').removeClass('has--error');
            $('.error-message[data-for=extraPhone]').addClass('has--error');
          }
          $('.error-message[data-for=errorConfirm]').addClass('has--error');
        },function(response){
          // Case when the account doesn't exists, send a 4 digits otp code
          appStorage.phone = phone;
          sendOTPCodePhone(phone,4,function(){},function(){})
          showJobSeekerPopup("verifyPhoneStep");
        }, function () {
          $('input[name=extraPhone]').addClass('has--error');
          $('.error-message[data-for=extraPhone]').addClass('has--error');
        });
      }
      // If the phone verification fails, display error messages
      else{
        $('input[name=extraPhone]').addClass('has--error');
        $('.error-message[data-for=extraPhone]').addClass('has--error');
      }

    }
    // Case for phone based accounts
    else if(appStorage.accountType == "phone"){
      var email = $('input[name=extraEmail]').val().trim();
      // Verify the email account
      if(verifyEmail(email)){
        // Check if the users account exits first
        newCheckAccount(email,function(response){
          // If the account is found send the 6 digits OTP code to the email
          if (response.response == "account") {
            appStorage.email = email;
            appStorage.secondStepLoginData = email;
            appStorage.secondStepLoginType = "email";
            appStorage.accountExist = 1;
            sendOTPCodeEmail(email,6,function(){},function(){})
            showJobSeekerPopup("signInJobSeekerStepOTPEmail");
          } else {
            // If is not found, display error messages
            $('.error-message[data-for=errorConfirm]').addClass('has--error');
            $('.error-message[data-for=extraEmail]').removeClass('has--error');
          }
          $('input[name=extraEmail]').addClass('has--error');
        },function(response){
          // If the account is not found, send the 4 digits OTP code
          appStorage.email = email;
          // Test to autoconfirm the account for Organic Bulk Strategy Version 2
          if (domain.otpSkippedCountry == "1" && appStorage.otpSkip == "yes") {
            updatePhoneOrEmailAccount(); return false;
          } else {
            sendOTPCodeEmail(email,4,function(){},function(){})
            showJobSeekerPopup("verifyEmailStep");
          }
        }, function () {
          $('input[name=extraEmail]').addClass('has--error');
          $('.error-message[data-for=extraEmail]').addClass('has--error');
        });
      }
      // if the email is not valid, display error messages
      else{
        $('input[name=extraEmail]').addClass('has--error');
        $('.error-message[data-for=extraEmail]').addClass('has--error');
      }
    }
  } else {
    showJobSeekerPopup("userSuccessfulConfirmation");
  }

}

/**
 * updatePhoneOrEmailAccount()
 * Updates the phone or email account, this is the function to be used in the
 * popups to manage both actions.
 *
 */

function updatePhoneOrEmailAccount(){
  if (event.stopPropagation) {
    event.stopPropagation();
    event.preventDefault();
  }
  // Inputs from the popup
  var code  = $('input[name=confirmCode]').val();

  // isValid default value if true, if one of the inputs is wrong, this value will
  // change to false.
  var isValid = true;

  // Clean previous error messages
  $('.has--error').removeClass('has--error');

  // if its all good we send the inform
  if (isValid) {
    if (appStorage.accountType == 'email' || appStorage.accountType == "sso") {
      // Updates the phone of an exisitng email account or an SSO account
      updateJobSeekerPhoneByOTP(code,appStorage.phone,function(){
        // Displays successful confirmation popup to the user
        if(appStorage.bulkRoute == "true"){
          routingEndPointAccountCreation();
        }else{
          showJobSeekerPopup("userSuccessfulConfirmation");
        }
      },function(){
        // Displays error messages if the update couldn't be performed
        $('input[name=confirmCode]').addClass('has--error');
        $('.error-message[data-for=errorConfirm]').addClass('has--error');
      })
    } else {
      // Updates the email of a phone account
      updateJobSeekerEmailByOTP(code,appStorage.email ,function() {
        // Displays successful confirmation popup to the user
        showJobSeekerPopup("userSuccessfulConfirmation");
      },function() {
        // Displays error messages if the update couldn't be performed
        $('input[name=confirmCode]').addClass('has--error');
        $('.error-message[data-for=errorConfirm]').addClass('has--error');
      })
    }
  }
}


/**
 * resendOTPCode
 * This resends the OTP code to the email or phone of the user
 * @param platform  Type of platform
 * @param length length of the code
 * @returns {boolean} Returns Boolean
 */

function resendOTPCode(platform,length){

  // If the platform is an email
  if (platform == "email") {
    sendOTPCodeEmail(appStorage.email,length,function(objAttempts){
      // OTP message
      let spamFolderMessage        = $('.error-message[data-for=spamFolder]');
      let remainingAttemptsMessage = $('.error-message[data-for=remainingAttempts]');
      // Process only for OTP apply popup
      //if (objAttempts.source == "apply_otp") {
        // If the user can send the OTP then remove the error message
        $('.error-message[data-for=ManyAttempts]').removeClass('has--error');
        // Change text for remaining attempts
        //Replace first the number if is not the first time
        remainingAttemptsMessage.text(remainingAttemptsMessage.text().replace(/\d/, objAttempts.remainingAttempts));
        //Replace the wildcard if is the first time
        remainingAttemptsMessage.text(remainingAttemptsMessage.text().replace("#number", objAttempts.remainingAttempts));
        remainingAttemptsMessage.text(remainingAttemptsMessage.text().replace("#variable", objAttempts.remainingAttempts));
      //}
      // Show message
      spamFolderMessage.addClass('has--error');
      remainingAttemptsMessage.addClass('has--error');
    },function(objAttempts){
      // Process only for OTP apply popup
      //if (objAttempts.source == "apply_otp") {
        $('.error-message[data-for=spamFolder]').removeClass('has--error');
        $('.error-message[data-for=remainingAttempts]').removeClass('has--error');
        addTimerMessageForOtp(objAttempts.attemptErrorDate, 5);
      //}
    })
  }
  // If the platform is a phone
  else{
    sendOTPCodePhone(appStorage.phone,length,function(){
      $('.error-message[data-for=ConfirmForm]').addClass('has--error');
    },function(){})
  }

}

/**
 * Add a message in the OTP Popup to know the remaining time to receive an OTP email again
 * @param baseDate date to start counting
 * @param minutesToWait in how many minutes the user can receive an OTP email
 */
function addTimerMessageForOtp(baseDate, minutesToWait){
  let manyAttempts = $('.error-message[data-for=ManyAttempts]');

  // Check if the counter is already counting
  if (!manyAttempts.hasClass('has--error')) {
    // Timer data
    let timer   = remainingTimeToOTP(baseDate, minutesToWait);
    let seconds = timer.split(":")[1];
    let minutes = timer.split(":")[0];
    manyAttempts.text(manyAttempts.text().replace(/#variable/, timer));

    // Timer to calculate the remaining seconds
    let timerId = setInterval(() => {

      // Stop timer when it's in zero
      if (timer == "0:00" || timer == "00:00") {
        // The user can re-send the OTP
        manyAttempts.removeClass('has--error');
        clearInterval(timerId);

      } else if (seconds - 1 < 0) {
        // When the next number is negative then restart seconds and subtract one minute
        seconds = 59
        minutes = minutes - 1;

        // To improve user experience, a 0 is added at the beginning when seconds are one digit long
      } else if (seconds - 1 < 10) {
        seconds = "0" + (seconds - 1)

        // Subtract one second
      } else {
        seconds--;
      }

      timer = minutes + ":" + seconds;
      // Update timer
      manyAttempts.text(manyAttempts.text().replace(/\d+:\d+/, timer));

    }, 1000);

    // Show message
    manyAttempts.addClass('has--error');
  }
}

/**
 * Get the minutes and seconds remaining to send a new OTP email
 * @param baseDate date to start counting
 * @param minutesToWait in how many minutes the user can receive an OTP email
 * @returns {string} Returns minutes and seconds remaining
 */
function remainingTimeToOTP(baseDate, minutesToWait){
  // Timer data
  // Replacing date to a standard because some browsers doesn't recognize it
  var tryAgainIn = new Date(baseDate.replace(" ","T"));
  tryAgainIn.setMinutes(tryAgainIn.getMinutes() + minutesToWait);

  // SETTING CANADIAN TIME
  // Options for timezone
  const timeOptions = {hourCycle: 'h23', dateStyle: 'short', timeStyle: 'medium'};
  // Specify default date formatting for now
  var dateActual = new Date(Date.now());
  // Configure timezone for Canada date format and timezone in Canada easter
  const formatterActualDate = new Intl.DateTimeFormat('en-CA', {timeZone: 'Canada/Eastern', ...timeOptions});
  // Convert Canada date to timespan format
  var canadianDateFormatter = formatterActualDate.format(dateActual)
  // Replacing date to a standard because some browsers doesn't recognize it
  var currentTime           = new Date(canadianDateFormatter.replace(", ","T"));

  // Remaining time calculations
  var milliseconds = Math.abs(tryAgainIn - currentTime);
  var seconds      = milliseconds / 1000;
  var minute       = Math.floor((seconds / 60) % 60);
  var second       = seconds % 60;
  minute           = (minute < 10) ? '0' + minute : minute;
  second           = (second < 10) ? '0' + second : second;

  // Timing response
  return `${minute}:${second}`;
}

/**
 * updateJobSeekerPhoneByOTP
 * This function stores the email into an exisitng phone account
 * @param code  OTP Code
 * @param email email account
 * @param successFunction Success Function
 * @param failFunction Fail Function
 * @returns {boolean} Returns Boolean
 */

function updateJobSeekerEmailByOTP(code,email,successFunction,failFunction){

  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }

  var params      = {};
  params.code     = code;
  params.email    = email;
  params.country  = domain.country;
  params.language = domain.language;
  params.jobSeekerContext = appStorage.jobSeekerContext;
  params.jobSeekerPath = appStorage.accountType;
  params.otpSkip = appStorage.otpSkip;
  params.isBulk = appStorage.bulkRoute;

  // Ajax file location
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/updateJobseekerEmail.php';
  $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        // Function sending the email was a success
        successFunction(objResponse);
      } else {
        // Function if something fail trying to send the email, Ex: user already
        // verify or non-existent
        failFunction(objResponse);
      }
      $('.is--waiting').removeClass("is--waiting");
    },
    fail: function(){
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    }
  });
}

/**
 * updateJobSeekerPhoneByOTP
 * This function stores the phone into an exisitng email account
 * @param code  OTP Code
 * @param phone Phone Number
 * @param successFunction Success Function
 * @param failFunction Fail Function
 * @returns {boolean} Returns Boolean
 */

function updateJobSeekerPhoneByOTP(code,phone,successFunction,failFunction){

  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }

  var params      = {};
  params.code     = code;
  params.phone    = phone;
  params.country  = domain.country;
  params.language = domain.language;
  params.jobSeekerContext = appStorage.jobSeekerContext;
  params.jobSeekerPath = appStorage.accountType;
  params.isBulk = appStorage.bulkRoute;


  // Ajax file location
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/updateJobseekerPhone.php';
  $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        // Function sending the email was a success
        successFunction(objResponse);
      } else {
        // Function if something fail trying to send the email, Ex: user already
        // verify or non-existent
        failFunction(objResponse);
      }
      $('.is--waiting').removeClass("is--waiting");
    },
    fail: function(){
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    }
  });
}

/**
 * Login OTP
 * Function to log in the user in the secondary data steps, when a user is asked
 * to add the phone number or an email account, it is prompt to be logged using an OTP code
 * This is the function that logs the user by entering the OTP Code
 * @param platform
 */

function logInOTP(platform){

  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }

  // The platform defines the paths of the validations that follows

  if(platform == "email"){
    var data = appStorage.email;
  }else{
    var data = appStorage.phone;
  }

  // Get the user's code
  var code = $("input[name=otpCheck]").val();

  // isValid default value if true, if one of the inputs is wrong, this value will
  // change to false.
  var isValid = true;

  // Clean previous error messages
  $('.has--error').removeClass('has--error');

  // The code needs to be 6 digits long
  if (code.length < 6) {
    isValid = false;
    $('input[name=otpCheck]').addClass('has--error');
    $('.error-message[data-for=otpCheck]').addClass('has--error');
    $('.is--waiting').removeClass("is--waiting");
  }

  // If its all good we send the form
  if (isValid) {
    var where = "/ajax/jobSeeker/popups/accountCreationFlow/ajax/loginJobSeekerAccountOTP.php";
    var params = {};
    params.data = data;
    params.code = code;
    params.jobId = getUrlSingleVar("id");
    params.accountType = appStorage.accountType;
    params.secondStepLoginData = appStorage.secondStepLoginData;
    params.secondStepLoginType = appStorage.secondStepLoginType;
    params.jobSeekerContext = appStorage.jobSeekerContext;
    params.country = domain.country;
    params.language = domain.language;

    $.post(where, params, function(response) {
      var objResponse = $.parseJSON(response);
      objResponse     = objResponse.payload;
      if (objResponse.response == "fail") {
        $('input[name=otpCheck]').addClass('has--error');
        $('.error-message[data-for=otpCheck]').addClass('has--error');
        $('.error-message[data-for=otpCheck]').text(objResponse.user_message);
        $('.is--waiting').removeClass("is--waiting");
      } else {
        if (appStorage.jobSeekerContext == "apply") {
          // Create OTP event for apply context
          let otpParams = {};
          otpParams.eventName = "apply_otp_submission";
          otpParams.step      = "apply_otp_submission";
          registerEventApply(otpParams);
        }
        routingEndPointAccountCreation();
      }

    });
  }

}

/**
 * This will add or remove the job to the favorites table depending if
 * the job was already in the user's favorites list.
 * @param string id
 * @param event event
 */
function addRemoveToFavoritesJob(jobId, event, source) {
  if (event.stopPropagation) {
    event.stopPropagation();
    event.preventDefault();
  }

  //if they are not log in we show then the user popup
  if (domain.jobSeekerLogin === '0') {

    appStorage.jobSeekerContext = 'favorites';
    appStorage.actionSouce = source;
    appStorage.jobSeekerFavToAdd = jobId;
    showJobSeekerPopup('checkEmailStep');

  } else {
    //If the button press has the class active-fav
    // we want to remove that jobid from the favorites
    if ($(event.target).hasClass('active-fav')) {

      // We remove the active-fav class from the clicked button
      $(event.target).removeClass('active-fav');

      // some buttons need to updates the text from "remove to favorites"
      // to "add to favorites"
      $(event.target).text($(event.target).attr('data-fav'));

      // On white page we want to update all the fav call to action
      if (app.pageName == 'whitepage') {
        $('.button--favHeader, button--ctaFav').removeClass('active-fav');
        $('.button--ctaFav').text($('.button--ctaFav').attr('data-fav'));
      }

      // on serp page desktop we want to also update the favorites
      if (app.pageName == 'serp' && domain.device == 'desktop') {
        $('.card__job[data-id=' + jobId + ']').
            find('.button--fav').
            removeClass('active-fav');
        $('.button--fav[data-button-id=' + jobId + ']').
            removeClass('active-fav');
        if ($('#jobPreview').html() != '' &&
            $('.card__job[data-id=' + jobId + ']').
                hasClass('card__job--preview'))
          addToJobIdsSessionStorage(jobId, $('#jobPreview').html());
      }
      var location = '';
      if (app.pageName == 'serp') {
        location = $('#nv-l').val();
      }
      //We remove the jobid from the job_favorite history
      var data = {};
      data.jobid = jobId;
      data.searchLocation = location;
      userEventTracket('job_favorite', data, 'delete');

    } else {

      //We add the active-fav class to update visuals and flag the clicked elemt
      $(event.target).addClass('active-fav');

      // some buttons need to updates the text from "add to favorites"
      // to "remove to favorites"
      $(event.target).text($(event.target).attr('data-rem'));

      // On white page we want to update all the fav call to action
      if (app.pageName == 'whitepage') {
        $('.button--favHeader, button--ctaFav').addClass('active-fav');
        $('.button--ctaFav').text($('.button--ctaFav').attr('data-rem'));
      }

      if (app.pageName == 'serp' && domain.device == 'desktop') {
        $('.card__job[data-id=' + jobId + ']').
            find('.button--fav').
            addClass('active-fav');
        $('.button--fav[data-button-id=' + jobId + ']').addClass('active-fav');
        if ($('#jobPreview').html() != '' &&
            $('.card__job[data-id=' + jobId + ']').
                hasClass('card__job--preview'))
          addToJobIdsSessionStorage(jobId, $('#jobPreview').html()`clear`);
      }

      //We add the jobid from the job_favorite history
      var data = {};
      data.jobid = jobId;
      userEventTracket('job_favorite', data);
    }

  }
}


/**
 * This function will insert and event in UET with the given eventName, and the data from the eventDataObject where its
 * key are the key of the array and the value the value of the array
 * @param eventName String  Name of the event to be inserted in UET
 * @param eventDataObject Object Complementary data for the event to be inserted where the key is the array name,
 * and the value is the array value Ex: Object.key = 'value'
 */

function sendEventToUET(eventName, eventDataObject){

  var params = {};
  params.eventName = eventName;
  params.eventData = eventDataObject;

  if(appStorage.firstEvent === "true"){
    params.isFirstEvent = "true";
    appStorage.firstEvent  = "false";
  }

  var where = "/ajax/send-event-to-UET.php";

  $.post(where,params,function (response){});

}

/**
 * Main function for the Email Alert Widget - RnD
 * This function is used to create an account and auto confirm it with only
 * the email. If the user has an account an attemps to use it, it will confirm
 * the email alert creation by sending the 6 digit otp code
 *
 * @param jobId string the jobid of the job that the user try to apply to
 */

function createEmailAlertWidget(jobId) {

  // Set the new step route
  appStorage.route            = 'confirmEmailAlertWidget';
  appStorage.bulkRoute        = "true";

  // Set the jobSeeker context
  appStorage.jobSeekerContext = 'bulk_email_widget';

  // Set the current JobId as active
  appStorage.activeJobId      = jobId;

  // Call the account creation process with autoconfirmation
  // by setting the otpSkipped value to yes
  if (domain.otpSkippedCountry == "1") {
    appStorage.otpSkip = "yes";
  } else {
    appStorage.otpSkip = "no";
  }

  // Start the account creation validation process
  applyByEmailOrPhoneStep();
}

/**
 * This function is used to show the notification pop up to users that
 * already signed up an account with us and if the user allows send push notifications
 *
 */

function showPushNotificationForLoggedUsers() {

   /*Case when a user tries to create an account using SSO in UK, we display
     the Push notification Popup
     domain.allowPushNotification represents the countries that are allowed
     appStorage.bulkRoute are the pages that come from whitepage
     appStorage.accountCreation if the account is being created
     appStorage.isPushNotificationPopupShown if the popup has been showed already
     appStorage.isPushNotificationPopupOnWhitepage if we are on whitepage
     appStorage.jobSeekerContext the salary widget popup cannot trigger the push notification popup*/
  if (
      domain.allowPushNotification == "1" &&
      appStorage.bulkRoute == "true" &&
      appStorage.accountCreation == undefined &&
      appStorage.isPushNotificationPopupShown === undefined &&
      appStorage.isPushNotificationPopupOnWhitepage === undefined &&
      appStorage.jobSeekerContext != 'salaryWhitepageWidget' &&
      domain.jobSeekerLogin == "1" &&
      !getUrlVars()['uit']
  ) {
    //Apply process context
    if (appStorage.jobSeekerContext == 'apply') {
      var data = {};
      data.jobid = appStorage.activeJobId;
      userEventTracket('job_ioa', data);
    }

    // Saving user default status
    if(!window.location.hostname.includes('dev')){
      saveNotificationDefaultStatus(Notification.permission);
    }

    // Ask the browser if the notifications are allowed before displaying the popup
    if (Notification.permission != "denied") {
      appStorage.isPushNotificationPopupShown = 'yes';
      appStorage.isPushNotificationPopupOnWhitepage = 'yes';

      requestNotificationPermissionSignIn();
      return false;
    }
  }
}

/**
 * This function creates a localStorage variable that expires after a given time
 * @param key name of the localStorage variable
 * @param value value of the localStorage variable
 * @param expiry in how long will this variable die? in milliseconds
 */
function setLocalStorageWithExpiry(key, value, expiry) {

  const now = new Date()
  // Params contains the value of the localStorage variable, as well as the expiry time
  const params = {
    value: value,
    expiry: now.getTime() + expiry,
  }
  // Set localStorage
  localStorage.setItem(key, JSON.stringify(params))
}

/**
 * This function gets a localStorage variable and returns it's value
 * If the localStorage is past it's expiry date, it will remove it
 * @param key the name of the localStorage variable
 * @returns value of the localStorage or null if the expiry date is past due
 */
function getLocalStorageWithExpiry(key) {

  // Get the localStorage variable
  let localStorageVar = localStorage.getItem(key)
  // If the variable doesn't exists, return null
  if (!localStorageVar) {
    return null
  }

  // Make the variable readable
  let val = JSON.parse(localStorageVar)
  let now = new Date()

  // Compare the expiry time of the item with the current time
  if (now.getTime() > val.expiry) {
    // If the variable is expired, delete it from storage
    localStorage.removeItem(key)
    return null
  }
  return val.value
}

/**
 * This function is the one in charge of showing the account gating popup after 30 seconds
 * Only in mobile and if the user is not logged in
 */
function showAccountGatingPopup(){

  if ((domain.testName == "talentWeb-accountGating-tax-converter" || domain.testName == "talentWeb-accountGating-salary-talentpedia") &&
      (domain.testGroup == "A" || domain.testGroup == "B")) {

    // This is to know whether or not the user has seen the experience before or not
    // If the user has, then we show the banner collapsed (only applicable to version B)
    if(domain.testGroup == "B" && getLocalStorageWithExpiry("accountGating")) {
      appStorage.accountGatingState = "collapsed";
    }

    // This is to not allow the user to close the popup (only applicable in version A)
    if(domain.testGroup == "A") {
      appStorage.accountGatingCollapse = "true";
    }

    appStorage.jobSeekerContext = "accountGating";
    // Activate the account gating experience
    showJobSeekerPopup("getStartedStep");

    // This sets a localStorage valid for only 30 minutes = 1800000
    setLocalStorageWithExpiry("accountGating", "true", 1800000)
  }

}

/**
 * This function is the one in charge of the collapse behaviour of the account gating, it uses the class "js--popupSlideHidden"
 * as hook to know the state of the popup and acts according to the state, if that class exists, it means that the popup is
 * collapsed, soo it will open the popup, if the class doesn't exist it will collapse the popup
 */
function togglePopupSlideUp(){
  // Selectors needed
  let popupBackground = $('.popup__background');
  let cardSlidePopup = $(".card--popup--slideUp");
  let cardSlidePopupBody = $(".card--popup--slideUp .card--popup__body");
  let cardSlideCollapser = $(".card--popup--slideUp .card--popup--collapsed")
  let buttonBack  = $(".card--popup--slideUp .button__back ");

  cardSlidePopupBody.slideToggle("slow");

  // Toggle open and close the popup slider according to a css class that we use as a hook to
  // identify the state of the popup
  if(cardSlidePopup.hasClass('js--popupSlideHidden')){
    // We prevent the scroll
    preventBodyScroll();
    // Remove the state css to open the popup
    cardSlidePopup.removeClass('js--popupSlideHidden');
    popupBackground.css("background", "rgba(48, 24, 63, 0.6)");
    popupBackground.removeClass("collapsed__popup__background");
    popupBackground.addClass('is--active');
    // We hide the purple re-engagement bar at the bottom
    cardSlideCollapser.addClass("collapsed");
    // Show the position absolute button back
    buttonBack.show();
    // Track event close
    let params = {};
    params.step = appStorage.currentPopup;
    params.type = "reengageBanner";
    sendEventToUET("accountGateCTA", params);
  }else{
    // We enable the scroll
    allowBodyScroll();
    // Add the state css to close the popup
    cardSlidePopup.addClass('js--popupSlideHidden');
    popupBackground.addClass("collapsed__popup__background");
    // We show the purple re-engagement bar at the bottom
    cardSlideCollapser.removeClass("collapsed");
    // Hide the position absolute button back
    buttonBack.hide();
    // Track event close
    let params = {};
    params.step = appStorage.currentPopup;
    params.type = "closeArrowCTA";
    sendEventToUET("accountGateCTA", params);
  }
}

/**
 * This function finishes the account gating experience, tracks the cta event, closes the popup and reloads the page
 * to complete the account creation process (does not apply to login process)
 */
function completeAccountGatingExperience() {

  let params = {};
  params.type = "closeCTA";
  params.step = "congratulationStep";
  sendEventToUET('accountGateCTA', params)

  closePopup();
  location.reload();
}

/**
 * This function register the tracks when user clicks on the employer products CTA "Learn More"
 */
function registerForEmployersEvent(pageType) {
  let params = {};
  params.pagetype = pageType;
  sendEventToUET('for_employers_landing', params)
}


/**
 * This will check the search made by the user, clean the filter fields that are empty  for SEO reasons
 * and register that search
 */
function checkSearchNew() {
  // Trim keyword and location values from the search bar input
  let keywordValue = $('#nv-k,#k_input').val().replace(/\+/g, '').trim();  
  let locationValue = $('#nv-l,#l_input').val().replace(/\+/g, '').trim();
  $('#nv-k,#k_input').val(keywordValue);
  $('#nv-l,#l_input').val(locationValue);
  
  //Remove useless inputs before doing a search for SEO reasons
  $(".jobFilters__listFilters  .input--radio").remove();
  // If the form was triggered by submit button or enter key, the 'lc' value will be removed
  if(event.target.nodeName.toLowerCase() === 'form') {
    $("input[name='lc']").val("");
  }

  if ($('#text-company').val() == '') {
    $('.magnifyingGlassSearch').remove();
  }

  // Remove empty filter parameters and "&p=1" when it's on the first results page
  $('.jobFilters > input, #text-company').each(function (){
    if(!this.value){
      this.remove()
    }

    if ($(this).attr("name") === "p" && this.value === "1"){
      this.remove()
    }
  });

  if (getUserHistoryXHR) {
    getUserHistoryXHR.abort();
  }

  // Only work for mobile
  if (domain.jobSeekerLogin !== "1" &&
      (domain.country === "ca" || domain.country === "us") &&
      app.pageName === "serp" &&
      app.pageVersion === "v2" &&
      event.target.className === 'c-search-bar__form') {
    // Increment search counter
    incrementCounterPopUp("job_search");
    addKeywordToSessionStorage(keywordValue, "job_search", keywordValue);
  }
}

/**
 * This function register the tracks when user clicks on the find jobs CTA.
 */
function registerFindJobsButtonClick(pageType) {

  let keyword  = null;
  let location = null;
  let params   = {};

  if ($("#nv-l").length) {
    location = $("#nv-l");
  } else if ($("#l_input").length) {
    location = $("#l_input")
  }

  if ($("#nv-k").length) {
    keyword = $("#nv-k");
  } else if ($("#k_input").length) {
    keyword = $("#k_input")
  }

  const urlParams = new URLSearchParams(window.location.search);
  params.keyword  = keyword.val();
  params.location = location.val();
  params.context  = pageType ? pageType : app.pageName;

  // Adding filters
  if (urlParams.has('date')) {
    params.filter_date = urlParams.get('date');
  }
  if (urlParams.has('radius')) {
    params.filter_radius = urlParams.get('radius');
  }
  if (urlParams.has('company')) {
    params.filter_company = urlParams.get('company');
  }
  if (urlParams.has('job_type')) {
    params.filter_job_type = urlParams.get('job_type');
  }
  if (urlParams.has('apply_type')) {
    params.filter_apply_type = urlParams.get('apply_type');
  }

  sendEventToUET('job_search', params);

}

/**
 * When clicking a category from the list a "chip--selected" class is added to the selected element
 * and a "chip--notSelected" class is added to the rest of the elements on the list
 * the selection class makes the element stand out from the others
 * the non selected class makes the element overshadow with an opacity
 * @param element is the selected element
 */
function selectAccountGatingCategory(element){
  // Status for uet tracking
  let status = "default";
  // Remove opacity class
  $(element).removeClass('chip--notSelected');
  // Remove selected class from an already selected element
  // Behaviour to unselect a category
  if ($(element).hasClass('chip--selected')) {
    $(element).removeClass('chip--selected');
    status = "unselecting";
  }
  // Add selection class to the selected element
  // Behaviour to select a category
  else {
    $('.chip').removeClass('chip--selected');
    $(element).addClass('chip--selected');
    status = "selecting"
  }
  // If some element has been selected add opacity to the others
  if ($('.chip').hasClass('chip--selected')) {
    $('.chip:not(.chip--selected)').addClass('chip--notSelected');
    $('[type="submit"]').removeClass('chip--notSelected');
    $('[type="submit"]').prop('disabled', false);
  }
  // Remove opacity If there's no element selected
  else {
    $('.chip').removeClass('chip--notSelected');
    $('[type="submit"]').addClass('chip--notSelected');
    $('[type="submit"]').prop('disabled', true);
  }

  // Tracking of the click in category
  let params = {};
  params.type = "jobCategoryCTA";
  params.value = $(element).data("value");
  params.status = status;
  params.step = appStorage.currentPopup;
  sendEventToUET("accountGateCTA", params)
}

/**
 * Function that stores the opened popup route in the appStorage,
 * we use this to know to which popup return when we click on the back button
 * If the value "route" is sent, we store it
 * If the value "route" is sent empty, we return the last popup
 */
function popupHistory(route) {
  // Define app storage variable
  if (!appStorage.popupHistory) appStorage.popupHistory = [];

  // Validate if the route is not empty and if the last route is not the same as the current route
  if (route &&
      appStorage.popupHistory[appStorage.popupHistory.length - 1] !== route) {
    appStorage.popupHistory.push(route);
  }

  // If route parameter is empty, the last element on the history array is removed
  if (!route) {
    // Delete last value (current popup)
    appStorage.popupHistory.pop();
    // Take the last element in the array (last popup) and show it
    let lastRoute = appStorage.popupHistory[appStorage.popupHistory.length - 1];

    // Trackers for accountGating
    if (appStorage.jobSeekerContext &&
        appStorage.jobSeekerContext === "accountGating") {
      let params = {};
      params.step = appStorage.currentPopup;
      params.type = "backClick";
      sendEventToUET("accountGateCTA", params);
    }

    showJobSeekerPopup(lastRoute);
  }
}

/**
 * This function performs an ajax call that saves the selected category/keyword on the database
 * if an error happens it is shown in the form
 */
function saveGatingCategory() {

  // Get the selected category value from the data-value attribute
  let keyword = $('.chip--selected').data("value");
  let categories = $('.button.chip');
  let submitCta = $('.button.button--primary.button--popup');

  // Clean previous error messages
  $('.error-message').removeClass('has--error');

  // Validate if the keyword is not empty
  let isValid = true;
  if (!keyword) {
    isValid = false;
    $('.error-message').addClass('has--error');
  }

  // Stores the Keyword via SSO Flow
  if (isValid && appStorage.accountType != "email") {
    let where = "/ajax/jobSeeker/popups/accountCreationFlow/ajax/updateAccountGatingUserKeyword.php";
    let params = {};
    params.keyword = keyword;
    params.email = appStorage.email;

    // We block the ctas from receiving any further action
    categories.css("pointer-events", "none");
    submitCta.css("pointer-events", "none");

    $.post(where, params, function (response) {
      let objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      if (objResponse.result === "fail") {
        $('.error-message').addClass('has--error');
        $('.error-message').text(objResponse.user_message);
      } else {
        // Track successful registration of the category
        let params = {};
        params.type = "doneCTA";
        params.categoryValue = keyword;
        params.status = "selecting";
        sendEventToUET("accountGateCTA", params);
        showJobSeekerPopup('successConfirmation');
      }
    });
  }
  // Stores the Keyword via Email Flow
  else if (isValid && appStorage.accountType == "email") {
    appStorage.accountGatingKeyword = keyword;
    sendOTPCodeEmail(appStorage.email, 6, function() {}, function() {});
    // Track successful registration of the category
    let params = {};
    params.type = "doneCTA";
    params.categoryValue = keyword;
    params.status = "selecting";
    params.step = appStorage.currentPopup;
    sendEventToUET("accountGateCTA", params);
    showJobSeekerPopup('verifyStep');
  }
}




/**
 * Send user's confirmation email with the OTP code to activate the account
 * @param code 6 digit code
 * @param successFunction
 * @param failFunction
 */
var loginJobSeekerEmailXHR = null;
function loginJobSeekerEmailByOTP(code,email,lenght, successFunction, failFunction) {
  //If there is already a request made we are going to proverent it
  //if all is good we just dissable the submitter button and form
  if(event.target){
    if($(event.target).find(".button[type=submit]").hasClass('is--waiting')){
      return false;
    }else{
      $(event.target).find(".button[type=submit]").addClass("is--waiting");
    }
  }

  // kill the any XHR request done before the must recent one
  if (window.loginJobSeekerEmailXHR) {
    window.loginJobSeekerEmailXHR.abort();
  }

  var params      = {};
  params.code = code;
  params.data = email;
  params.lenght = lenght;
  params.country = domain.country;
  params.language = domain.language;
  params.jobSeekerContext = appStorage.jobSeekerContext;
  params.accountGatingKeyword = appStorage.accountGatingKeyword;
  params.newRouting = appStorage.newRouting;
  params.jobSeekerPath = appStorage.accountType;
  params.activeJobId = appStorage.activeJobId;
  params.applyType = appStorage.applyType;
  params.otpSkip = appStorage.otpSkip;
  params.isBulk = appStorage.bulkRoute;
  params.k_mbg = appStorage.k_mbg;
  params.suggested_mbg = appStorage.suggested_mbg;
  params.l_mbg = appStorage.l_mbg;
  params.click_id = getUrlVars()['click_id'];
  params.pbc_id = getUrlVars()['pbc_id'];
  params.id = getUrlVars()['id'];
  // Validate the app exist and we have the page type set
  if (typeof app === 'object' && app.pageName !== undefined) {
    params.pagetype = app.pageName;
  }

  // Ajax file location
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/loginJobSeekerAccountOTP.php';
  window.loginJobSeekerEmailXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.response == 'ok') {
        // Function sending the email was a success
        successFunction(objResponse);
      } else {
        // Function if something fail trying to send the email, Ex: user already
        // verify or non-existent
        failFunction(objResponse);
      }
      $('.is--waiting').removeClass("is--waiting");
    },
    fail: function(){
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    }
  });
}

/**
 * New function to check the email and verify if there is an account attach to it or not
 */
function checkEmailStep(){
  // Get email value
  let email = $('input[name=emailCheck]').val().trim();
  let OTPLength  = 6;
  // Check if the email is correct, if it not correct we show then an error message
  if (verifyEmail(email)) {
    // Store the email account for verification processes
    appStorage.email = email;
    // Check if the email given have an jobSeeker account attach to it
    checkAccount(email, function(response) {
      if(response.password_type == "legacy"){ // TODO password_type to "password" once the new routing is running everywhere.
        // Trigger confirmation popup to login the user
        showJobSeekerPopup("signInJobSeekerStep");
      } else {
        // Send the OTP code for email based accounts
        sendOTPCodeEmail(email, OTPLength, function () {}, function () {});
        // Setting context to log in user after they confirm their account
        appStorage.isLogginIn = "yes";
        // Trigger confirmation popup to login the user
        showJobSeekerPopup("loginOtpEmailStep");
      }
    }, function(response) {
      // Setting context to create in user after they confirm their account
      appStorage.isLogginIn = "no";
      // Send the OTP code for email based accounts
      sendOTPCodeEmail(email, OTPLength, function () {}, function () {});
      // Trigger category selector
      showJobSeekerPopup("verifyEmailStep");
    }, function (response) {
      // Showing error message if the email's domain is not valid,
      // this validation is made in the /ajax/jobSeeker/checkJobSeekerAccount.php
      // by using the supression list
      appStorage.email = null;
      $('input[name=emailCheck]').addClass('has--error');
      $('.error-message[data-for=emailCheck]').addClass('has--error');
    });
  } else {
    // Showing error message if the email was not a valid one,
    // this validation is made by verifyEmail function
    appStorage.email = null;
    $('input[name=emailCheck]').addClass('has--error');
    $('.error-message[data-for=emailCheck]').addClass('has--error');
  }
}

/**
 * Function that save the category selected by the user
 */
function saveGatingCategoryNew(){

  // Get the selected category value from the data-value attribute
  let keyword = $('.chip--selected').data("value");
  let categories = $('.button.chip');
  let submitCta = $('.button.button--primary.button--popup');

  // Clean previous error messages
  $('.error-message').removeClass('has--error');

  // Validate if the keyword is not empty
  let isValid = true;
  if (!keyword) {
    isValid = false;
    $('.error-message').addClass('has--error');
  }

  if(isValid){
    appStorage.accountGatingKeyword = keyword;
    sendOTPCodeEmail(appStorage.email, 6, function() {}, function() {});
    // Track successful registration of the category
    let params = {};
    params.type = "doneCTA";
    params.categoryValue = keyword;
    params.status = "selecting";
    params.step = appStorage.currentPopup;
    sendEventToUET("accountGateCTA", params);
    //SSO Users are already login when they come back
    if(domain.jobSeekerLogin == '1'){
      updateJobSeekerCategory(keyword,function (){
        showJobSeekerPopup('successConfirmation');
      },function (){
        console.log("Fail for whatever reason");
      })
    }else{
      showJobSeekerPopup('verifyEmailStep');
    }

  }
}

var updateJobSeekerCategoryXHR = null;
function updateJobSeekerCategory(keyword,successFunction,failFunction){

  var params      = {};
  params.keyword = keyword;
  // Ajax file location
  var where = '/ajax/jobSeeker/popups/accountCreationFlow/ajax/updateAccountGatingUserKeyword.php';
  window.updateJobSeekerCategoryXHR = $.ajax({
    type: 'POST',
    url: where,
    data: params,
    success: function(response) {
      var objResponse = $.parseJSON(response);
      objResponse = objResponse.payload;
      //Response routing
      if (objResponse.result == 'ok') {
        // Function sending the email was a success
        successFunction(objResponse);
      } else {
        // Function if something fail trying to send the email, Ex: user already
        // verify or non-existent
        failFunction(objResponse);
      }
      $('.is--waiting').removeClass("is--waiting");
    },
    fail: function(){
      //Allow button to be reactivate
      $('.is--waiting').removeClass("is--waiting");
    }
  });
}

/**
 * New function to confirm the email of the user
 *
 */
function confirmEmailAccount() {

  var code = $('input[name=confirmCode]').val();
  if (appStorage.isLogginIn == "yes") {
    loginJobSeekerEmailByOTP(code, appStorage.email, 6, function (response) {

      // Register Job search
      registerJobSearchAccountCreation();
      // Action after user is logged
      newEndpointAccountCreation();

    }, function (response) {
      // Display errors if it cannot be confirmed
      $('.error-message[data-for=confirmCode]').html(response.user_message);
      $('input[name=confirmCode]').addClass('has--error');
      $('.error-message[data-for=confirmCode]').addClass('has--error');
    });

  } else {
    // We confirm the email account
    confirmJobSeekerEmailByOTP(code, appStorage.email, 6, function (response) {

      // Register Job search
      registerJobSearchAccountCreation();
      // Call success popup
      appStorage.accountCreation = 'yes';
      showJobSeekerPopup('successConfirmation');

    }, function (response) {
      // Display errors if it cannot be confirmed
      $('.error-message[data-for=confirmCode]').html(response.user_message);
      $('input[name=confirmCode]').addClass('has--error');
      $('.error-message[data-for=confirmCode]').addClass('has--error');
    });
  }
}

/**
 * Function to register job search
 * when user is creating a new account
 */
const registerJobSearchAccountCreation = () => {

  let keyword = "";
  let location = "";
  let params   = {};

  if ($("#nv-l").length) {
    location = $("#nv-l").val();
  } else if ($("#l_input").length) {
    location = $("#l_input").val();
  } else if (getUrlVars()['l'] !== undefined) {
    location = getUrlVars()['l'];
  }

  if ($("#nv-k").length) {
    keyword = $("#nv-k").val();
  } else if ($("#k_input").length) {
    keyword = $("#k_input").val();
  } else if (getUrlVars()['k'] !== undefined) {
    keyword = getUrlVars()['k'];
  }

  // Check if we have both keyword
  // and location to store this event, if
  // one of this params are empty stop
  if (keyword === "" || location === "") {
    return;
  }

  const urlParams = new URLSearchParams(window.location.search);
  params.keyword  = keyword
  params.location = location;

  // Validate the app exist and we have the page type set
  if (typeof app === 'object' && app.pageName !== undefined) {
    params.context = app.pageName;
  }

  // Adding filters
  if (urlParams.has('date')) {
    params.filter_date = urlParams.get('date');
  }
  if (urlParams.has('radius')) {
    params.filter_radius = urlParams.get('radius');
  }
  if (urlParams.has('company')) {
    params.filter_company = urlParams.get('company');
  }
  if (urlParams.has('job_type')) {
    params.filter_job_type = urlParams.get('job_type');
  }
  if (urlParams.has('apply_type')) {
    params.filter_apply_type = urlParams.get('apply_type');
  }

  if (sessionStorage.keywords !== undefined) {

    // Get the json keyword from session
    let keywords = JSON.parse(sessionStorage.keywords);

    let job_clicks = keywords.job_click;

    if (Object.keys(job_clicks).length !== 0) {
      // For each job click add event
      $.each(job_clicks, function (key, val) {
        // Assign more params to the event
        Object.assign(val, params);
        val.keyword = val.title;
      });
      multipleEventsUserTracker('job_click', JSON.stringify(job_clicks));
    }

    let job_searches = keywords.job_search;
    if (Object.keys(job_searches).length !== 0) {
      // For each job click add event
      $.each(job_searches, function (key, val) {
        // Assign more params to the event
        Object.assign(val, params);
        val.keyword = val.title;
      });
      multipleEventsUserTracker('job_search', JSON.stringify(job_searches));
    }

  } else {
    // Register event
    userEventTracket('job_search', params);
  }
}

/**
 * Function to get the code in the new design with number boxes
 * @param parentId Id of the parent container of the inputs
 */
const enterCode = (parentId) => {
  const inputElements = [...document.getElementById(`${parentId}`).querySelectorAll('input.code-input')];
  inputElements.forEach((ele, index) => {
    ele.addEventListener('keydown', (e) => {
      // if the keycode is backspace & the current field is empty
      // focus the input before the current. Then the event happens
      // which will clear the "before" input box.
      if (e.keyCode === 8 && e.target.value === '') {
        inputElements[Math.max(0, index - 1)].focus();
      }
    });
    ele.addEventListener('input', (e) => {
      // take the first character of the input
      const [first, ...rest] = e.target.value;
      // first will be undefined when backspace was entered, so set the input to ""
      e.target.value = first ?? '';
      const lastInputBox = index === inputElements.length - 1;
      const didInsertContent = first !== undefined;
      if (didInsertContent && !lastInputBox) {
        // continue to input the rest of the string
        inputElements[index + 1].focus()
        inputElements[index + 1].value = rest.join('')
        inputElements[index + 1].dispatchEvent(new Event('input'))
      }
      if (lastInputBox && e.target.value !== "") {
        const code = inputElements.map(({value}) => value).join('')
        submitCode(code);
      }
    });
  });
}

/**
 * Function to submit otp code in new design
 * @param otp
 */
const submitCode = (otp) => {
  // Show loader
  $("#loader-popup").show();
  // Disabled inputs
  $('input[name=confirmCode]').prop('disabled', true);
  if (appStorage.isLogginIn == "yes") {
    loginJobSeekerEmailByOTP(otp, appStorage.email, 6, function (response) {
      // Register Job search
      registerJobSearchAccountCreation();
      // Action after user is logged
      newEndpointAccountCreation();
    }, function (response) {
      // Display errors if it cannot be confirmed
      $('input[name=confirmCode]').addClass('has--error');
      $('.error-message[data-for=confirmCode]').html(response.user_message);
      $('.error-message[data-for=confirmCode]').addClass('has--error');
      // Hide loader
      $("#loader-popup").hide();
      // Enable inputs only if the account is not temporary blocked
      if (response.reason !== "blocked") {
        $('input[name=confirmCode]').prop('disabled', false);
      }
    });
  } else {
    // We confirm the email account
    confirmJobSeekerEmailByOTP(otp, appStorage.email, 6, function (response) {
      // Call success popup
      appStorage.accountCreation = 'yes';
      showJobSeekerPopup('successConfirmation');
      // Register Job search
      registerJobSearchAccountCreation();
    }, function (response) {
      // Display errors if it cannot be confirmed
      $('input[name=confirmCode]').addClass('has--error');
      $('.error-message[data-for=confirmCode]').html(response.user_message);
      $('.error-message[data-for=confirmCode]').addClass('has--error');
      // Hide loader
      $("#loader-popup").hide();
      // Enable inputs only if the account is not temporary blocked
      if (response.reason !== "blocked") {
        $('input[name=confirmCode]').prop('disabled', false);
      }
    });
  }
}

/**
 * Save in local storage
 * Function to store in local storage the questions
 * answered by the user
 * @param storageKey
 * @param objectData
 */
function saveDataInLocalStorage(storageKey, objectData) {

  const mergedJobData = {
    ...JSON.parse(localStorage.getItem(storageKey)),
    ...objectData
  }

  const jsonData = JSON.stringify(mergedJobData);
  localStorage.setItem(storageKey, jsonData);
}

/**
 * This function finishes the account gating experience, tracks the cta event, closes the popup and reloads the page
 * to complete the account creation process (does not apply to login process)
 */
function newEndpointAccountCreation() {

  let params = {};
  params.type = "closeCTA";
  params.step = "congratulationStep";
  sendEventToUET('accountGateCTA', params)

  if (getUrlVars()['uit']) {
    replaceStateURL('uit', '');
    replaceStateURL('action', '');
    replaceStateURL('platform', '');
    replaceStateURL('jobSeekerContext', '');
  }

  //Apply process context
  if (appStorage.jobSeekerContext === 'apply' && !appStorage.popupClosed) {

    var data = {};
    data.jobid = appStorage.activeJobId;
    if (app.pageName === 'serp') {
      data.searchLocation = $('#nv-l').val();
    }
    userEventTracket('job_ioa', data);
    sendToJobSource();

  } else if (appStorage.jobSeekerContext === 'user-page') {

    // Redirect to the proper user page according to end point set in email
    let url = getUrlVars();
    let params = Object.entries(url).map(item => item[0] + '=' + item[1]).join('&');
    if (typeof appStorage.jobSeekerUserPage == 'undefined') {
      appStorage.jobSeekerUserPage = 'user-pages'
    }
    window.location.href = domain.settings.language_folder + appStorage.jobSeekerUserPage + '?' + params;

  } else if (appStorage.jobSeekerContext === 'accountGating_savejob' && !appStorage.popupClosed) {

    // Save job favorite process
    saveJobFavorite();

  } else if (appStorage.doNotReload === true) {

    appStorage.doNotReload = false;
    closePopup();

  } else if (appStorage.jobSeekerContext === 'gfj' && app.pageName === 'whitepage') {

    sendToJobSource();

  } else if (appStorage.popupClosed) {

    closePopup();

  } else {

    closePopup();
    location.reload();

  }

  appStorage.popupClosed = false;
}

function redirectTo(pageToRedirect) {
  let queryString = "";
  if (pageToRedirect === "salary") {
    queryString = new URLSearchParams({"job":appStorage.job});
  } else if (pageToRedirect === "tax-calculator") {
    queryString = new URLSearchParams({"from":appStorage.from,"region":appStorage.region,"salary":appStorage.salary});
  } else if (pageToRedirect === "jobs") {
    queryString = new URLSearchParams({"k":appStorage.k,"l":appStorage.l});
  }
  window.location.href = `${pageToRedirect}?${queryString}`;
}

/**
 * Save job function to store the event of saving the job for job seeker
 */
function saveJobFavorite() {

  //We add the job id from the job_favorite history
  let formData = new FormData();
  const where = '/ajax/page_jobs/registerJobFavorite.php';

  const jobId = appStorage.jobSeekerFavToAdd ?? sessionStorage.getItem('job-to-save');
  let favoriteParams = loadDataForFavoriteEvents(jobId, "save");

  for (let key in favoriteParams) {
    formData.append(key, favoriteParams[key]);
  }

  fetch(where, {method: 'POST', body: formData}).then((response) => {
    location.reload();
  });
}

/**
 * Function to make an ajax call when the user clicks on an action from the job card menu
 * @param action user's action (save, hide, report, share)
 * @param jobId job card id where the menu was opened
 */
function cardMenuAction(action, jobId, source) {

  appStorage.cta_position = source;

  if (action == "save") {

    let intentOfSaveParams = loadDataForFavoriteEvents(jobId, 'intent_of_save');
    registerEventApply(intentOfSaveParams);

  }

  // If the Job Seeker is not logged in, we ask to create an account
  if (domain.jobSeekerLogin === '0') {
    appStorage.jobSeekerContext = 'accountGating_savejob';
    appStorage.jobSeekerFavToAdd = jobId;
    appStorage.newRouting = true;
    delete appStorage["applyType"];
    sessionStorage.setItem("job-to-save", jobId);
    // sessionStorage.setItem("cta_position", source);

    replaceStateURL('id', jobId);
    showJobSeekerPopup('checkEmailStep');
  } else if(!$(`[data-button-id=${jobId}]`).hasClass('is--disable')) {
    // Ajax where to make the request depending on the user's action
    let where = '';
    switch (action) {
      case 'save' :
        // TODO: AJAX path to save a job
        where = '/ajax/page_jobs/registerJobFavorite.php';
        if ($(`[data-button-id=${jobId}]`).hasClass("is-saved")) return;

        // Change main button state
        $(`[data-button-id=${jobId}]`).removeClass("not-saved").addClass("is-saved").addClass('is--disable').attr("disabled", true);
        // Show undo message at the bottom of the card
        // $(`[data-id=${jobId}] .card__job-saved`).addClass("is-saved");
        // openJobPreview(jobId);
        break;
      case 'remove' :
        // TODO: AJAX path to save a job
        where = '/ajax/page_jobs/registerJobFavorite.php';
        if ($(`[data-button-id=${jobId}]`).hasClass("not-saved")) return;

        // Change main button state
        $(`[data-button-id=${jobId}]`).removeClass("is-saved").addClass("not-saved").addClass('is--disable').attr("disabled", true);
        // Hide undo message at the bottom of the card
        // $(`[data-id=${jobId}] .card__job-saved`).removeClass("is-saved");
        break;
        /*
      case 'hide':
        where = '/ajax/';
        break;
      case 'report':
        where = '/ajax/';
        break;
      case 'share':
        where = '/ajax/';
        break;
        */
      default:
        return false;
    }

    let params = loadDataForFavoriteEvents(jobId, action);

    // Ajax file location
    $.ajax({
      type   : 'POST',
      url    : where,
      data   : params,
      success: function (response) {

        let objResponse = $.parseJSON(response);
        // Response routing
        if (objResponse.result === 'ok') {
          
          $(`[data-button-id=${jobId}]`).removeClass('is--disable').attr("disabled", false);

          // Change button classes depending on the user's action
          if (action === "save") {
          } else if (action === "remove") {
          }
        }
      }
    });
  }
}

/**
 * Function to load the necessary information for the events related to jobs favorites
 * @param jobId job card id where the menu was opened
 * @param action user's action (save, hide, report, share)
 */
function loadDataForFavoriteEvents(jobId, action) {

  let params    = {};
  let jobCard   = $(`[data-id=${jobId}]`);
  let urlParams = new URLSearchParams(location.search);

  if (action == "save") {
    params.eventName = 'save_job';
  } else if (action == "remove") {
    params.eventName = 'unsave_job';
  } else {
    params.eventName = action;
  }

  // Get values to load the event data
  params.method       = action;
  params.jobid        = jobId;
  params.country      = domain.country;
  params.language     = domain.language;
  params.cta_position = appStorage.cta_position;
  params.page_number  = urlParams.has('p') ? urlParams.get('p') : '1';

  if (jobCard) {
    params.card_position          = jobCard.attr("card-position");
    params.job_attribute_new_job  = jobCard.find('.card__job--new').text() != "";
    params.job_attribute_promoted = jobCard.find('.card__job-sponsored').text() != "";
    params.job_attribute_salary   = jobCard.find('.card__job-badges-holder .card__job-badge-salary').text();
    params.job_attribute_job_type = jobCard.find('.card__job-badges-holder .card__job-badge-job-type').text();
    params.job_attribute_apply    = jobCard.find('.card__job-badges-holder .card__job-badge-apply').text() != "";
    params.job_attribute_remote   = jobCard.find('.card__job-badges-holder .card__job-badge-remote').text() != "";
  }

  return params;
}

/**
 * Get favorite from session storage
 * @returns {boolean}
 */
// const checkUserFavorites = () => {
//
//   if (domain.jobSeekerLogin === '0') {
//     return true;
//   }
//
//   if (sessionStorage.getItem("job-to-save")) {
//     let source = "";
//     let jobId  = sessionStorage.getItem("job-to-save");
//
//     if (sessionStorage.getItem("cta_position")) {
//       source = sessionStorage.getItem("cta_position");
//       sessionStorage.removeItem("cta_position");
//     }
//
//     cardMenuAction("save", jobId, source);
//   }
// }

/**
 * Set the right context for popup when click is made on elements which are supposed to trigger the popup. The function
 * will not call the popup if the user already seen a popup triggered by the same function.
 */
function newRoutingSEOTriggers() {
  // Check if the user already seen the popup, is aimed and if is logged in.
  if (!sessionStorage.getItem("popupViewed") && domain.country === "ca" && domain.jobSeekerLogin === "0"
      && domain.testName === "seo_accountGating" && domain.testGroup === "B") {
    $('button#calculate-net-salary,button#submit-job-search,button#submit-salary-search,.c-card--show-more-btn,#converter').on('click', function (e) {
      if (!sessionStorage.getItem("popupViewed")) {
        // Do not prevent default by default.
        let preventDefault = false;

        // Set default jobSeekerContext.
        appStorage.jobSeekerContext = "accountGating_default";

        if ($(e.target)[0].className === "c-card--show-more-btn") {
          /*
           * If click on the show more salary button in salary page, set appStorage.doNotReload to have a track that the user
           * clicked in when will close the popup to not reload the page.
           */
          appStorage.doNotReload = true;
        } else if ($(e.target)[0].id === "submit-salary-search" || $(e.target)[0].id === "submit-job-search" || $(e.target)[0].id === "calculate-net-salary") {
          /*
           * If click on the submit buttons, set preventDefault as true because redirect must be cancelled and will be
           * done at the end of the account creation process.
           */
          preventDefault = true;
          /*
           * Get all the inputs from the form and set them inside the appStorage to find them back at the end of the
           * process to redirect the user at the right page.
           */
          $($(e.target.closest("form"))[0].querySelectorAll("input,select")).each(function () {
            appStorage[$(this)[0].name] = $(this)[0].value;
          });
          if ($(e.target)[0].id === "submit-job-search") {
            // Set a specific context for the submit search button.
            appStorage.jobSeekerContext = "home";
          }
        } else if ($(e.target)[0].className === "input--text c-form__input c-form__input--icon") {
          // If click happened on inputs in Converter.
          appStorage.doNotReload = true;
        }

        // Prevent default if necessary.
        if (preventDefault === true) {
          event.preventDefault();
        }
        // Set the newRouting as true.
        appStorage.newRouting = true;
        // Call the popup in peace.
        showJobSeekerPopup("checkEmailStep");
      }
    })
  }

  /**
   * Call the popup after 10 seconds if the user didn't see a popup yet.
   */
  // Check if the user already seen the popup, is aimed, is not logged in and is in right pages.
  if (domain.country === "ca" && domain.jobSeekerLogin === "0" && typeof app === 'object'
      && (app.pageName === "taxCalculator" || app.pageName === "salarySearch" || app.pageName === "converter")
      && domain.testName === "seo_accountGating" && domain.testGroup === "B") {
    // Set the timeout.
    setTimeout(function () {
      // Do not call the popup if user see a popup meanwhile.
      if (!sessionStorage.getItem("popupViewed")) {
        // Set the new routing as true to get the new popups.
        appStorage.newRouting = true;
        // Set the jobSeekerContext.
        appStorage.jobSeekerContext = "accountGating_default";
        showJobSeekerPopup("checkEmailStep");
      }
    }, 10000);
  }
}

/**
 * This function searches for divs that have an "ajax" attribute and launches
 * the ajax call on the attribute
 */
let  activeAjaxCallPublic = 0;
function talentCallAjax() {

  // Look for all divs with ajax attribute
  $("[ajax]").each(function () {

    if (activeAjaxCallPublic >= 64) {
      return false;
    }

    // Call that endpoing end and fill in the info
    var url = $(this).attr("ajax");
    var e = $(this);

    // Change the attribute name to ajaxCalled to prevent re-firing
    e.attr({ajaxCalled: e.attr("ajax")})
    e.removeAttr("ajax");

    activeAjaxCallPublic++;
    // Make the get ajax call
    $.get(url, function (data) {
      activeAjaxCallPublic--;
      e.html(data);
    })
  })
}

/**
 * This function is in charge of enabling the talent ajax call on load
 */
function initializeTalentCallAjax() {
  talentCallAjax();
  window.setInterval(function () {
    talentCallAjax();
  }, 500);
}

/**
 * Editable global object to store global variables can be use in all the other
 * js scripts if the common.js is include
 * @type {{}} const Object
 */
const appStorage = {};
appStorage.jobSeekerContext;
appStorage.firstEvent = "true";
/**
 * Initial function for all the pages on the public site.
 * Keep it at the end of the file -att: William
 */
$(document).ready(function() {
  // checkFavoritesOnJobListing();
  preferredLanguageCookieSetup();
  //SSO landing logic
  easySignIn();

  // Function to display a popup when a user comes from the home page
  // (www.talent.com), to suggest the creation of an account
  // Commented by Ben
  // showCreatePopupFromHomeRedirect();
  showPushNotificationForLoggedUsers();

  // Function to redirect the user to my notifications page if they come from emails
  userNotificationRedirect();

  // Function to trigger the confirmation process when the link is used
  userSuccessConfirmationPopup();
  //This will call jquery.mask.js
  callMaskJS();
  // Function to be able to use ajax call
  initializeTalentCallAjax();
  // getCookiesTosBanner();
  if (document.documentMode || /Edge/.test(navigator.userAgent)) {
    cssVars();
  }

  // Only trigger account gating if the user is not logged in
  if((domain.jobSeekerLogin != "1") && (domain.device == "mobile") && (domain.language == "en") && (domain.country == "us") &&
      (app.pageName == "salarySearch" || app.pageName == "taxCalculator" || app.pageName == "converter" || app.pageName == "talentpedia-landing" || app.pageName == "talentpedia-questions")) {

    // Timer function, helps to pause or resume the timer whether a jobseeker popup is opened or closed
    var Timer = function(callback, delay) {
      var timerId, start, remaining = delay;

      // Pause timeout
      this.pause = function() {
        window.clearTimeout(timerId);
        timerId = null;
        remaining -= Date.now() - start;
      };

      // Resume timeout
      this.resume = function() {
        if (timerId) return;
        start = Date.now();
        timerId = window.setTimeout(callback, remaining);
      };

      this.resume();
    };
    
    window.accountGatingTimer = new Timer(function () {
      showAccountGatingPopup();
    }, 10000);
    
    // If user clicks on a text input
    $("input.input--text").focus(function() {
      window.accountGatingTimer.pause();
      // If the popup is not shown
      if ($(".card--popup--slideUp").length === 0) {
        showAccountGatingPopup();
      }
    });
  }
});