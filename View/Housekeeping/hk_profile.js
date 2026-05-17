window.onload = function(){
    loadProfile();

    let form = document.getElementById("profileForm");

    if(form){
        form.addEventListener("submit", function(e){
            e.preventDefault();
            updateProfile(this);
        });
    }
};

function loadProfile(){
    getData("../../Controller/HousekeepingController/hk_profile.php?action=get_profile", function(data){
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

    if(name.length > 0){
        firstLetter = name.charAt(0).toUpperCase();
    }

    let avatarPreview = document.getElementById("avatarPreview");

    if(avatarPreview){
        avatarPreview.innerHTML = firstLetter;
    }
}

function updateProfile(form){
    let formData = new FormData(form);
    formData.append("action", "update_profile");

    postData("../../Controller/HousekeepingController/hk_profile.php", formData, function(data){
        if(data.success){
            showMessage("Profile updated successfully");
            loadProfile();
        }
        else{
            showMessage(data.message);
        }
    });
}

