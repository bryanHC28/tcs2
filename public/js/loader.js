const Loader = {
    __loader: null,
    show: () => {
        if (this.__loader == null) {
            var divContainer = document.createElement("div");
            divContainer.style.position = "fixed";
            divContainer.style.top = "0";
            divContainer.style.right = "0";
            divContainer.style.bottom = "0";
            divContainer.style.left = "0";
            divContainer.style.width = "100%";
            divContainer.style.height = "100%";
            divContainer.style.zIndex = "99999";
            divContainer.style.backgroundColor = "rgba(250, 250, 250, 0.80)";

            var div = document.createElement("div");
            div.style.position = "fixed";
            div.style.left = "50%";
            div.style.top = "50%";
            div.style.zIndex = "9999";
            div.style.height = "70px";
            div.style.width = "70px";
            div.style.margin = "-50px 0px 0px -50px";
            div.style.border = "8px solid #e1e1e1";
            div.style.borderRadius = "50%";
            div.style.borderTop = "8px solid #F36E21";
            div.animate(
                [
                    { transform: "rotate(0deg)" },
                    { transform: "rotate(360deg)" },
                ],
                {
                    duration: 2000,
                    iterations: Infinity,
                }
            );
            divContainer.appendChild(div);
            this.__loader = divContainer;
            document.body.appendChild(this.__loader);
        }
        this.__loader.style.display = "";
    },
    hide: () => {
        if (this.__loader != null) {
            this.__loader.style.display = "none";
        }
    },
};
