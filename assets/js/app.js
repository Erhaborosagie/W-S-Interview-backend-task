function generateCode() {
  /**Replace this function block with logic for retrieving the generated code from the server */
  let data = {
    method: "post",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json"
    },

    body: JSON.stringify({
      //
    })
  };
  fetch("server.php", data)
    .then(js => {
      console.log(js);
      return js.text();
    })
    .then(response => {
      let generateCode = document.querySelector(".generated-code");
      generateCode.innerHTML = response;
    });
}

function validateCode() {
  /**Replace this function block with logic for validating the token. You should replace the "validated-code-status" with the result of your validation */
  let code = document.forms["genForm"]["token"].value;
  let data = {
    method: "post",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json"
    },

    body: JSON.stringify({
      code: code
    })
  };
  let validatedCodeStatus = document.querySelector(".validated-code-status");
  let status = [
    "The code you supplied is true",
    "The code you supplied is not correct"
  ];
  fetch("server.php", data)
    .then(js => {
      return js.text();
    })
    .then(response => {
      console.log(response);
      validatedCodeStatus.innerHTML = status[response];
    });
}
