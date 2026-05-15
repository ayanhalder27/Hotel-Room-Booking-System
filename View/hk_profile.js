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
    getData("../Controler/hk_profile.php?action=get_profile", function(data){
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

            updateProfileView(data.user);
        }
        else{
            showMessage(data.message);
        }
    });
}

function updateProfile(form){
    let formData = new FormData(form);
    formData.append("action", "update_profile");

    postData("../Controler/hk_profile.php", formData, function(data){
        if(data.success){
            showMessage("Profile updated successfully");
            loadProfile();
        }
        else{
            showMessage(data.message);
        }
    });
}

function updateProfileView(user){
    let name = user.name ?? "Supervisor";
    let email = user.email ?? "housekeeping@luxestay.com";

    let firstLetter = "S";

    if(name.length > 0){
        firstLetter = name.charAt(0).toUpperCase();
    }

    let avatarPreview = document.getElementById("avatarPreview");
    let sidebarAvatar = document.getElementById("sidebarAvatar");
    let sidebarName = document.getElementById("sidebarName");
    let sidebarEmail = document.getElementById("sidebarEmail");

    if(avatarPreview){
        avatarPreview.innerHTML = firstLetter;
    }

    if(sidebarAvatar){
        sidebarAvatar.innerHTML = firstLetter;
    }

    if(sidebarName){
        sidebarName.innerHTML = name;
    }

    if(sidebarEmail){
        sidebarEmail.innerHTML = email;
    }
}