function clearCarrierSelect() {
  let select = document.querySelector("#ywcdd_carrier");
  let selectOption = Array.from(
    document.querySelectorAll("#ywcdd_carrier > option")
  );

  if (select && selectOption) {
    selectOption.forEach(option => {
      // Se il carrierId non è disponibile cerca il Corriere standard.
      if (params.carrierId == "") {
        if (option.innerText !== "Corriere standard") {
          if (option.value !== "") {
            option.remove();
          }
        }
        // option.selected = "selected";
      } else {
        // Se il carrierId è disponibile filtra i corrieri lasciando solo quello uguale all'ID.
        if (option.value !== params.carrierId) {
          if (option.value !== "") {
            option.remove();
          }
        }
        // option.selected = "selected";
      }
    });
  }
}

var mutationObserver = new MutationObserver(function(mutations) {
  mutations.forEach(function(mutation) {
    if (
      mutation.target.className === "ywcdd_select_delivery_date_content" &&
      mutation.addedNodes.length > 0
    ) {
      clearCarrierSelect();
    }
  });
});

mutationObserver.observe(document.documentElement, {
  attributes: true,
  characterData: true,
  childList: true,
  subtree: true,
  attributeOldValue: true,
  characterDataOldValue: true
});

window.addEventListener("load", clearCarrierSelect);
