/**
 * Grand Horizon Resort — Core Guest Dashboard Engine Frontend Architecture Router
 * Mimics seamless enterprise dynamic state views using standard fetch operations.
 */
const App = (() => {
  // Application-wide cached internal elements states
  const states = {
    activeRoute: "dashboard_home",
    sidebarElement: null,
    stageContainer: null,
    toastInstance: null,
    loyaltyApplied: false,
  };

  /**
   * Engine Initializer Core Setup Hooks Pipeline
   */
  const init = () => {
    // Intercept container DOM objects definitions
    states.sidebarElement = document.getElementById("sidebar");
    states.stageContainer = document.getElementById("dynamic-view-stage");

    const toastEl = document.getElementById("appToast");
    if (toastEl) {
      states.toastInstance = new bootstrap.Toast(toastEl);
    }

    registerCoreClickInterceptors();
    registerMobileResponsiveSwitches();

    // Kick off dynamic entry view component deployment standard flow rule
    loadPartial(states.activeRoute);
  };

  /**
   * Orchestrates Seamless View Partial Content Replacements Operations
   * @param {string} viewTargetName - Name of the file inside views/guest/partials/
   */
  const loadPartial = async (viewTargetName) => {
    if (!states.stageContainer) return;

    // Apply global elegant loader mask view
    states.stageContainer.innerHTML = `
            <div class="d-flex align-items-center justify-content-center py-5 my-5">
                <div class="spinner-border text-gold" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading Layout Folios...</span>
                </div>
            </div>
        `;

    try {
      // Emulate clean asynchronous service worker loops processing layout fragments templates
      const targetEndpointUrl = `partials/${viewTargetName}.php`;
      const response = await fetch(targetEndpointUrl);

      if (!response.ok) {
        throw new Error(
          `Platform Engine routing dropped code payload execution: ${response.status}`,
        );
      }

      const htmlMarkupResult = await response.text();

      // Re-render pipeline smoothly
      states.stageContainer.className = "content-stage-fade mt-4";
      states.stageContainer.innerHTML = htmlMarkupResult;
      states.activeRoute = viewTargetName;

      updateSidebarActiveItemIndicator();
      bindDynamicTemplateEventContexts(viewTargetName);
      window.scrollTo({ top: 0, behavior: "smooth" });
    } catch (error) {
      console.error("Critical Runtime Router Fault Exception Raised:", error);
      states.stageContainer.innerHTML = `
                <div class="alert alert-danger p-4 rounded-3 border-0 shadow-sm">
                    <h5 class="fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i>Content Load Error</h5>
                    <p class="m-0 text-sm">Failed to resolve view payload for **${viewTargetName}**. Verify file deployments or XAMPP rules configurations.</p>
                </div>
            `;
    }
  };

  /**
   * Intercepts Top Navbar and Menu Items Interactions Controls
   */
  const registerCoreClickInterceptors = () => {
    document.body.addEventListener("click", (event) => {
      const anchorElementNode = event.target.closest("[data-partial]");
      if (!anchorElementNode) return;

      event.preventDefault();
      const targetPartialString =
        anchorElementNode.getAttribute("data-partial");

      // Clean up mobile side nav overlay structures instantly if open
      if (states.sidebarElement) {
        states.sidebarElement.classList.remove("mobile-revealed");
      }

      loadPartial(targetPartialString);
    });
  };

  /**
   * Highlights Active Vertical Navigation Element Anchor Panels
   */
  const updateSidebarActiveItemIndicator = () => {
    if (!states.sidebarElement) return;

    const activeNavLinks = states.sidebarElement.querySelectorAll(".nav-link");
    activeNavLinks.forEach((linkNode) => {
      const linkageScopeMatch =
        linkNode.getAttribute("data-partial") === states.activeRoute;
      if (linkageScopeMatch) {
        linkNode.classList.add("active");
      } else {
        linkNode.classList.remove("active");
      }
    });
  };

  /**
   * Injects Custom Event Bindings Hooks depending on newly deployed dynamic layouts markup arrays
   */
  const bindDynamicTemplateEventContexts = (activeLayoutName) => {
    if (activeLayoutName === "reviews") {
      setupStarRatingInteractionsEngine();
    }
  };

  /**
   * Global Trigger Messaging Pipeline Engine Notification Toast Helper
   */
  const notifyUser = (messageText) => {
    const msgContainer = document.getElementById("toastMessage");
    if (msgContainer && states.toastInstance) {
      msgContainer.innerHTML = messageText;
      states.toastInstance.show();
    }
  };

  /**
   * Core Mobile Slide-Out Submenus Framework Integrations Setup
   */
  const registerMobileResponsiveSwitches = () => {
    const structuralToggleBtn = document.getElementById("mobileSidebarToggle");
    if (structuralToggleBtn) {
      structuralToggleBtn.addEventListener("click", () => {
        if (states.sidebarElement) {
          states.sidebarElement.classList.toggle("mobile-revealed");
        }
      });
    }
  };

  /**
   * Star-Rating Vector Interactive Controller Engine Context mapping rules
   */
  const setupStarRatingInteractionsEngine = () => {
    const functionalStarContainers = document.querySelectorAll(
      ".star-rating-interactive",
    );
    functionalStarContainers.forEach((wrapperBlock) => {
      const actualStarsVector = wrapperBlock.querySelectorAll("i");
      actualStarsVector.forEach((star) => {
        star.addEventListener("click", function () {
          const selectedValueIndex = parseInt(this.getAttribute("data-value"));
          wrapperBlock.setAttribute("data-selected-score", selectedValueIndex);

          actualStarsVector.forEach((s, idx) => {
            if (idx < selectedValueIndex) {
              s.className = "fa-solid fa-star text-gold pointer";
            } else {
              s.className = "fa-regular fa-star pointer";
            }
          });
        });
      });
    });
  };

  // Concrete Global Interactive Action Handlers Mocking Engine Backends Outputs
  const handleSearchSubmit = (e) => {
    e.preventDefault();
    notifyUser(
      "<i class='fa-solid fa-circle-check text-gold me-2'></i> Querying inventory records live... Updates loaded.",
    );
  };

  const handleBookingConfirm = (e) => {
    e.preventDefault();
    loadPartial("booking_confirmation");
  };

  const toggleLoyaltyDiscount = (checkboxInput) => {
    const discountRow = document.getElementById("loyaltyDiscountRow");
    const finalPriceContainer = document.getElementById("finalBookingTotal");
    if (!finalPriceContainer) return;

    if (checkboxInput.checked) {
      discountRow.classList.remove("d-none");
      finalPriceContainer.innerText = "$735.50";
      notifyUser(
        "<i class='fa-solid fa-tags text-gold me-2'></i> Loyalty point balance values deducted from current invoice summary[cite: 66, 83].",
      );
    } else {
      discountRow.classList.add("d-none");
      finalPriceContainer.innerText = "$775.50";
    }
  };

  const filterBookings = (filterCriterion) => {
    const targetingCards = document.querySelectorAll(".booking-mega-card");
    targetingCards.forEach((card) => {
      const itemMatch =
        filterCriterion === "all" ||
        card.getAttribute("data-stay-status") === filterCriterion;
      card.style.display = itemMatch ? "block" : "none";
    });

    const activeTabsNav = document.querySelectorAll(
      ".custom-luxury-pills .nav-link",
    );
    activeTabsNav.forEach((tab) => tab.classList.remove("active"));
    event.target.classList.add("active");
  };

  const cancelBookingTrigger = (bookingIdString) => {
    if (
      confirm(
        `Are you absolutely sure you wish to cancel reservation ${bookingIdString}?`,
      )
    ) {
      notifyUser(
        "<i class='fa-solid fa-circle-info text-danger me-2'></i> Cancellation request sent. Ledger logs updated.",
      );
      loadPartial("my_bookings");
    }
  };

  const handleServiceSubmit = (e) => {
    e.preventDefault();
    notifyUser(
      "<i class='fa-solid fa-concierge-bell text-gold me-2'></i> Room Service ticket pushed onto operational dashboards queue.",
    );
    document.getElementById("serviceRequestForm").reset();
  };

  const handleReviewSubmit = (e) => {
    e.preventDefault();
    notifyUser(
      "<i class='fa-solid fa-star text-gold me-2'></i> Feedback securely processed via verified transaction checkpoints loops[cite: 63].",
    );
    loadPartial("reviews");
  };

  const handleProfileUpdate = (e) => {
    e.preventDefault();
    notifyUser(
      "<i class='fa-solid fa-id-card text-gold me-2'></i> Identity mapping fields rewritten successfully[cite: 52].",
    );
  };

  const handlePasswordChange = (e) => {
    e.preventDefault();
    notifyUser(
      "<i class='fa-solid fa-key text-success me-2'></i> Biometric credentials and key phrase structures updated[cite: 52].",
    );
    e.target.reset();
  };

  const handleAvatarUpload = (fileInput) => {
    if (fileInput.files && fileInput.files[0]) {
      notifyUser(
        "<i class='fa-solid fa-image text-gold me-2'></i> Profile media array uploaded successfully[cite: 52].",
      );
    }
  };

  const deleteReviewTrigger = (btnContext) => {
    if (
      confirm(
        "Permanently wipe this verified customer feedback record from master schema tables?",
      )
    ) {
      btnContext.closest(".review-node-card").remove();
      notifyUser(
        "<i class='fa-solid fa-trash-can text-danger me-2'></i> Record wiped[cite: 64].",
      );
    }
  };

  return {
    init,
    loadPartial,
    handleSearchSubmit,
    handleBookingConfirm,
    toggleLoyaltyDiscount,
    filterBookings,
    cancelBookingTrigger,
    handleServiceSubmit,
    handleReviewSubmit,
    handleProfileUpdate,
    handlePasswordChange,
    handleAvatarUpload,
    deleteReviewTrigger,
  };
})();

// Hook global DOM content ready system initialization standard process rules
document.addEventListener("DOMContentLoaded", App.init);
