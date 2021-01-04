/**
 * 文件上传
 * var upload = new roiwkUpload({
 *  domain: "server"
 * });
 * upload.upload(document.querySelector("#upload").files[0])
 *
 * @param {Object}} config
 */
var roiwkUpload = function(config = null) {
    let option = {
        domain: "http://127.0.0.1:8888",
        error_to_delete: true,
        preprocess_route:"/process",
        uploading_route:"/process",
        uploading_method:"post",
        delete_route:"/process",
        delete_method:"delete",
        preprocess_error_callback: function(){
            console.log(errMsg);
        },
        uploading_error_callback: function(){
            console.log(errMsg);
        },
        precent_callback: function(percent){
            console.log(percent);
        },
    };
    if (option !== null) {
        for (let key in config) {
            option[key] = config[key]
        }
    }

    let uploadFile;
    let chunkSize = 0;
    let subDir = '';
    let error = false;
    let errMsg = '';

    let upload = (file) => {
        uploadFile = file;
        preprocess();
    }

    let preprocess = async() => {
        try {
            let response = await fetch(
                option.domain + option.preprocess_route + '?filename=' + uploadFile.name + '&size=' + uploadFile.size,
                {cache: "no-store",}
                );
            let result = await response.json();
            if (result.error == 0) {
                chunkSize = result.chunk_size;
                subDir = result.sub_dir;
                uploading();
            } else {
                error = true;
                errMsg = result.err_msg;
                console.error(errMsg);
            }
        } catch (error) {
            console.log(error);
            if (option.preprocess_error_callback.toString() === "function(){}") {
                throw error;
            } else {
                return option.preprocess_error_callback();
            }
        }
    }

    let blobSlice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice;

    let uploading = async() => {
            let chunkTotal = Math.ceil(uploadFile.size / chunkSize);
            let start = 0;
            let index = 1;
            let uploadingErr = false;

            while (!uploadingErr && index <= chunkTotal) {
                let end = index * chunkSize;
                if (end > uploadFile.size) {
                    end = uploadFile.size;
                }

                let formData = new FormData();
                formData.append('sub_dir', subDir);
                formData.append('filename', uploadFile.name);
                formData.append('chunk_total', chunkTotal);
                formData.append('chunk_index', index);
                formData.append('chunk_file', blobSlice.call(uploadFile, start, end));

                try {
                    let response = await fetch(option.domain + option.uploading_route, {
                            method: option.uploading_method,
                            body: formData,
                            cache: "no-store",
                        })
                    let result = await response.json();
                    console.log(result);

                    if (result.error == 0) {
                        let precent = parseInt(index / chunkTotal * 100);
                        option.precent_callback(precent);
                        if (result.finish == 1) {
                            //* finish
                            return;
                        }
                    } else {
                        error = true;
                        errMsg = result.err_msg;
                        remoteDelete();
                    }
                } catch (error) {
                    if (response.status === 0) {
                        sleep(5000);
                        uploading();
                    } else {
                        uploadingErr = true;
                        remoteDelete();
                        if (option.uploading_error_callback.toString() === "function(){}") {
                            throw errorThrown;
                        } else {
                            return option.uploading_error_callback();
                        }
                    }
                }

                start = end;
                index++;
            }

    }

    let remoteDelete = () => {
        if (!option.error_to_delete) {
            return;
        }
        let formData = new FormData();
        formData.append('sub_dir', subDir);
        formData.append('filename', uploadFile.name);
        fetch(option.domain + option.delete_route, {
            method: option.delete_method,
            body: formData,
            cache: "no-store",
        })
        .then(response => {
            // nothing to do
        }).catch(err => {
            // error
        });
    }

    let sleep = (milliSecond) => {
        let wakeUpTime = new Date().getTime() + milliSecond;
        while (true) {
            if (new Date().getTime() > wakeUpTime) {
                return;
            }
        }
    }

    let set = (key, value) => {
        option[key] = value;
    }

    let showOptions = () => {
        return option;
    }

    return {
        upload,
        set,
        getOptions:showOptions,
        error,
        errMsg
    };
};
