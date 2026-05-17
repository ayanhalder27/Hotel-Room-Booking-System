window.onload = function(){
    loadProfile();

    let form = document.getElementById("profileForm");

    if(form){
        form.addEventListener("submit", function(e){
            e.preventDefault();
            updateProfile(this);
        });
    }

    let profilePicInput = document.getElementById("profilePicInput");

    if(profilePicInput){
        profilePicInput.addEventListener("change", function(){
            previewSelectedProfilePic(this);
        });
    }
};

function loadProfile(){
    getData("../../Controler/HousekeepingController/hk_profile.php?action=get_profile", function(data){
        if(data.success && data.user){
            let nameInput = document.getElementById("profileName");
            let emailInput = document.getElementById("profileEmail");
            let phoneInput = document.getElementById("profilePhone");

            if(nameInput){
                nameInput.value = data.user.name ?? "";
            }

            if(emailInput){
                emailInput.value = data.user.email ?? "";
            }

            if(phoneInput){
                phoneInput.value = data.user.phone ?? "";
            }

            updateAvatarPreview(data.user);
        }
        else{
            showMessage(data.message);
        }
    });
}

function updateAvatarPreview(user){
    let name = user.name ?? "Supervisor";
    let firstLetter = "S";
    let avatarPreview = document.getElementById("avatarPreview");

    if(user.profile_pic && avatarPreview){
        avatarPreview.innerHTML = "<img src='../../" + user.profile_pic + "' alt='Profile picture'>";
        return;
    }

    if(name.length > 0){
        firstLetter = name.charAt(0).toUpperCase();
    }

    if(avatarPreview){
        avatarPreview.innerHTML = firstLetter;
    }
}

function previewSelectedProfilePic(input){
    let avatarPreview = document.getElementById("avatarPreview");

    if(!avatarPreview || !input.files || input.files.length == 0){
        return;
    }

    let file = input.files[0];
    let reader = new FileReader();

    reader.onload = function(e){
        avatarPreview.innerHTML = "<img src='" + e.target.result + "' alt='Profile picture preview'>";
    };

    reader.readAsDataURL(file);
}

function updateProfile(form){
    let formData = new FormData(form);
    formData.append("action", "update_profile");

    postData("../../Controler/HousekeepingController/hk_profile.php", formData, function(data){
        if(data.success){
            showMessage("Profile updated successfully");
            loadProfile();
        }
        else{
            showMessage(data.message);
        }
    });
}

