/**
 * 文件上传
 * var upload = new roiwkUpload({
 *  domain: "server"
 * });
 * upload.upload($("#upload").prop('files')[0])
 *
 * @param {Object}} config
 */
var roiwkUpload = function(config = null) {

    let option = {
        domain: "http://127.0.0.1:8888",
        preprocess_route:"/process",
        preprocess_method:"get",
        uploading_route:"/process",
        uploading_method:"post",
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

    let preprocess = () => {
        $.ajax({
            type: option.preprocess_method,
            url: option.domain + option.preprocess_route,
            dataType: "json",
            async: false,
            cache: false,
            crossDomain: true,
            data : {
                filename: uploadFile.name,
                size: uploadFile.size
            },
            success: function(data, textStatus, jqXHR){
                let result = data;
                if (result.error == 0){
                    chunkSize = result.chunk_size;
                    subDir = result.sub_dir;
                    uploading();
                } else {
                    error = true;
                    errMsg = result.err_msg;
                    console.error(errMsg);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (option.preprocess_error_callback.toString() === "function(){}") {
                    throw errorThrown;
                } else {
                    return option.preprocess_error_callback();
                }
            }
        });
    }

    let blobSlice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice;

    let uploading = () => {
        // async 这个应该是同步执行吧
        (async function() {
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

                let precent = await new Promise((resolve,reject)=>{
                    $.ajax({
                        type: option.uploading_method,
                        url: option.domain + option.uploading_route,
                        dataType: "json",
                        cache: false,
                        crossDomain: true,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(data, textStatus, jqXHR){
                            if (data.error == 0){
                                let a = parseInt(index / chunkTotal * 100);
                                resolve(a);
                                if (data.finish == 1) {
                                    //finish
                                    return;
                                }
                            } else {
                                error = true;
                                errMsg = data.err_msg;
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            if (XMLHttpRequest.status === 0) {
                                sleep(5000);
                                uploading();
                            } else {
                                uploadingErr = true;
                                if (option.uploading_error_callback.toString() === "function(){}") {
                                    throw errorThrown;
                                } else {
                                    return option.uploading_error_callback();
                                }
                            }
                        }
                    });
                });

                option.precent_callback(precent);

                start = end;
                index++;
            }
        })();
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
