
// Set the XSRF token from the cookie
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// CSRF Interceptor
axios.interceptors.request.use(config => {
    if (config.method?.toLowerCase() === "post") {
        const hashMeta = document.querySelector('meta[name="csrf-hash"]');
        const nameMeta = document.querySelector('meta[name="csrf-name"]');

        if (hashMeta && nameMeta) {
            const csrfName = nameMeta.getAttribute('content');
            const csrfHash = hashMeta.getAttribute('content');

            if (config.data instanceof FormData) {
                config.data.append(csrfName, csrfHash);
            } else if (typeof config.data === "object" && config.data !== null) {
                config.data = {
                    ...config.data,
                    [csrfName]: csrfHash
                };
            } else {
                config.data = {
                    [csrfName]: csrfHash
                };
            }
        }
    }
    return config;
}, error => {
    return Promise.reject(error);
});
axios.interceptors.response.use(
    response => {
        if (response.config?.method?.toLowerCase() === "post") {
            if (response.data?.csrfName && response.data?.csrfHash) {
                let nameMeta = document.querySelector('meta[name="csrf-name"]');
                let hashMeta = document.querySelector('meta[name="csrf-hash"]');

                if (!nameMeta) {
                    nameMeta = document.createElement('meta');
                    nameMeta.setAttribute('name', 'csrf-name');
                    document.head.appendChild(nameMeta);
                }
                if (!hashMeta) {
                    hashMeta = document.createElement('meta');
                    hashMeta.setAttribute('name', 'csrf-hash');
                    document.head.appendChild(hashMeta);
                }

                nameMeta.setAttribute('content', response.data.csrfName);
                hashMeta.setAttribute('content', response.data.csrfHash);
                console.log(response.data)
                return response;
            }
            else {
                // 🚨 No CSRF in response → reload with error params
                // const params = new URLSearchParams(window.location.search);

                // params.set("error", "true");
                // params.set("api", encodeURIComponent(response.config.url || ""));
                // params.set("http_status", response.status || 0);

                // window.location.href =
                //     window.location.pathname + "?" + params.toString();
            }
        }
        return response;
    },
    error => {
        if (error.config?.method?.toLowerCase() === "post") {
            if (error.response?.data?.csrfName && error.response?.data?.csrfHash) {
                let nameMeta = document.querySelector('meta[name="csrf-name"]');
                let hashMeta = document.querySelector('meta[name="csrf-hash"]');

                if (!nameMeta) {
                    nameMeta = document.createElement('meta');
                    nameMeta.setAttribute('name', 'csrf-name');
                    document.head.appendChild(nameMeta);
                }
                if (!hashMeta) {
                    hashMeta = document.createElement('meta');
                    hashMeta.setAttribute('name', 'csrf-hash');
                    document.head.appendChild(hashMeta);
                }

                nameMeta.setAttribute('content', error.response.data.csrfName);
                hashMeta.setAttribute('content', error.response.data.csrfHash);
            } else {
                // 🚨 No CSRF in error response → reload with error params
                const params = new URLSearchParams(window.location.search);

                params.set("error", "true");
                params.set("api", encodeURIComponent(error.config.url || ""));
                params.set("http_status", error.response?.status || 0);

                window.location.href =
                    window.location.pathname + "?" + params.toString();
            }
        }
        return Promise.reject(error);
    }
);
