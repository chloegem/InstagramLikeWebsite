const pages = {};
const base_url = "http://localhost/Social/Backend/";

pages.Console = (title, values, oneValue = true) => {
  console.log("---" + title + "---");
  if (oneValue) {
    console.log(values);
  } else {
    for (let i = 0; i < values.length; i++) {
      console.log(values[i]);
    }
  }
  console.log("--/" + title + "---");
};

pages.loadFor = (page) => {
  eval("pages.load_" + page + "();");
};

pages.postAPI = async (api_url, api_data, api_token = null) => {
  try {
    return await axios.post(api_url, api_data, {
      headers: {
        Authorization: "token " + api_token,
      },
    });
  } catch (error) {
pages.Console("Error from Signup API", error);
  }
};
pages.getAPI = async (api_url) => {
  try {
    return await axios(api_url);
  } catch (error) {
pages.Console("Error from Linking (GET)", error);
  }
};

// 
// Register Linking 
// 

pages.load_signup = () =>{

    const signup_btn = document.getElementById("signup");
    const result = document.getElementById("response");

    const responseHandler = () => {
        result.innerHTML = '<div id = "response" class = "response_font"></div>';
      };
    const signup = async () => {

        const signup_url = base_url + "register.php";
    
        const signup_data = new URLSearchParams();
        signup_data.append("first_name", document.getElementById("first_name").value);
        signup_data.append("last_name", document.getElementById("last_name").value);
        signup_data.append("email", document.getElementById("email").value);
        signup_data.append("password", document.getElementById("password").value);
    
        const response = await pages.postAPI(
          signup_url,
          signup_data
        );
        if (response.data.error) {
          result.innerHTML =
            '<div id = "response" class = "response_font">' +
            response.data.error +
            "</div>";
        } else {
          result.innerHTML =
            '<div id = "response" class = "response_font">' +
            response.data.success +
            "<br>Go to Login!</div>";
        }
      };
      signup_btn.addEventListener("click", signup);
};