let toggleModalStatus = false;

let toggleModal = function()
{
  let getModal= document.querySelector(".modal");
  let getProfilePic= document.querySelector(".changeprofilepic");
  let getExit = document.querySelector(".exit");

  if (toggleModalStatus === false)
  {
    getModal.style.display= "block";
    toggleModalStatus=true;
    document.getElementByClass("modal").addEventListener("click", hideModal);
  }
  else
  {
    getModal.style.display= "none";
    toggleModalStatus=false;
  }
}

let toggleEditStatus = false;

let toggleEdit = function()
{
  let getEditList= document.querySelector("#edit-list");

  if (toggleEditStatus === false)
  {
    getEditList.style.display= "block";
    toggleEditStatus=true;

  }
  else
  {
    getEditList.style.display= "none";
    toggleEditStatus=false;
  }
}

//function toggleEdit()
//{
//  document.querySelector('#edit-lists').style.visibility = "hidden";


//}

function triggerUpload()
{
  document.querySelector('#profilepic');
}
function displayImage(e)
{
  if (e.files[0])
  {
    document.querySelector('#uploadprofile').style.visibility = "visible";
    document.querySelector('#uploadprofile').style.display = "block";
    var reader = new FileReader();

    reader.onload = function(e)
    {
      document.querySelector('#profiledisplay').setAttribute('src', e.target.result);
    }
    reader. readAsDataURL(e.files[0]);
  }
}


function triggerUploadImg()
{
  document.querySelector('img-upload');
}

function displayAttachImage(e)
{
  if (e.files[0])
  {
    var reader = new FileReader();

    reader.onload = function(e)
    {
      document.querySelector('#imageattach').setAttribute('src', e.target.result);
    }
    reader. readAsDataURL(e.files[0]);
  }
}
function displayAttachVideo(e)
{
  if (e.files[0])
  {
    var reader = new FileReader();

    reader.onload = function(e)
    {
      document.querySelector('#videoattach').setAttribute('src', e.target.result);
    }
    reader. readAsDataURL(e.files[0]);
  }
}

function displayAttachFile(e)
{
  if (e.files[0])
  {
    var reader = new FileReader();

    reader.onload = function(e)
    {
      document.querySelector('#fileattach').setAttribute('value', e.target.result);
    }
    reader. readAsDataURL(e.files[0]);
  }
}



function hideUpload()
{
  document.querySelector('#uploadprofile').style.visibility = "hidden";
  document.querySelector('#uploadprofile').style.display = "none";
}








function triggerModal()
{
  document.querySelector('.wrapper').style.filter = "blur(3px)";
  document.querySelector('.modal-container').style.display = "block";
}

function triggerStream()
{
  var video = document.querySelector("#videoElement");

  if (navigator.mediaDevices.getUserMedia)
  {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function (stream)
      {
        video.srcObject = stream;
      })
      .catch(function (err0r)
      {
        console.log("Something went wrong!");
      });
  }
}



