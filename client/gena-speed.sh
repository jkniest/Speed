#!/usr/bin/env bash

folderPath="${HOME}/.gena-speed"

function checkDependency() {
    echo "Checking dependency: ${1}"

    if ! type "$1" &> /dev/null ;
    then
        echo "Dependency missing: ${1}. Please install"
        exit 1
    fi
}

function checkDependencies() {
    checkDependency curl
    checkDependency python
}

function createSpeedFolder() {
    if [ ! -e "${folderPath}" ];
    then
        echo "Speed folder does not exists. Creating it now.."
        mkdir -p "${folderPath}"
    fi
}

installSpeedtestCli() {
    if [ ! -e "${folderPath}/speedtest-cli" ];
    then
        echo "Speedtest executable missing. Downloading it now.."
        curl -Lo "${folderPath}/speedtest-cli" https://raw.githubusercontent.com/sivel/speedtest-cli/master/speedtest.py
        chmod +x "${folderPath}/speedtest-cli"
    fi
}

setServerUrl() {
    if [ ! -e "${folderPath}/.server" ];
    then
        echo "Server URL?"
        read serverPath

        echo "${serverPath}" > "${folderPath}/.server"
    else
        serverPath="$(cat "${folderPath}/.server")"
    fi

    if [[ ${serverPath} != */ ]]
    then
        serverPath="${serverPath}/"
    fi
}

setToken() {
    if [ ! -e "${folderPath}/.token" ];
    then
        echo "Server Token?"
        read serverToken

        echo "${serverToken}" > "${folderPath}/.token"
    else
        serverToken="$(cat "${folderPath}/.token")"
    fi
}

executeSpeedtest() {
    result=$(${folderPath}/speedtest-cli --simple)
    echo "$result"
}

getDownloadSpeed() {
    echo "Extracting download speed.."
    download=$(echo "${result}" | grep -Poi "Download: \K([0-9]+\.[0-9]+)")
    download=$(echo "${download//.}")

    echo "Download speed: ${download}"
}

getUploadSpeed() {
    echo "Extracting upload speed.."
    upload=$(echo "${result}" | grep -Poi "Upload: \K([0-9]+\.[0-9]+)")
    upload=$(echo "${upload//.}")

    echo "Upload speed: ${upload}"
}

function sendToServer() {
    echo "Using server: ${serverPath}"
    curl --data "token=${serverToken}&up=${upload}&down=${download}" "${serverPath}api/result"
}

function main() {
    echo "Hello world!"

    checkDependencies
    createSpeedFolder
    installSpeedtestCli
    setServerUrl
    setToken
    executeSpeedtest
    getDownloadSpeed
    getUploadSpeed
    sendToServer

    echo "Bye world!"
}

main
