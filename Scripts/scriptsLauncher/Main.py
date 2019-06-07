import os
import webbrowser
ipDomain = "172.16.217.117"
def crackPassword():
	pwdFile = open("./passwords.txt",'r')
	pwdList = pwdFile.read()
	pwdFile.close()
	pwdList = pwdList.split("\n")
	for i in range(len(pwdList)-1):
		print("Mots de passe de l'utilisateur : "+ str(i))
		print("Hash : "+pwdList[i])
		os.system("findmyhash MD5 -h "+pwdList[i]+" -g")
	
def scanReseau():
	choix = -1
	while choix != 0:
		print("*1* quels appareils sont connecte a mon reseau ?")
		print("*2* quels ports sont ouverts et les services actifs sur une machine ?")
		print("*0* retour au menu principal")
		choix = input()

		if int(choix) == 1:
			print("Entrer l'addresse reseau du reseau  a scanner sous la fomre xxxx.xxxx.xxxx.xxxx/xx : ")
			ipMachine = raw_input()
			print("voici les appareils connectes a votre reseaux : ")
			os.system("nmap -sP "+ipMachine)
		if int(choix) == 2:
			print("Entrer l'addresse ip de la machine a scanner : (par defaut serveur IIS)")
			ipMachine = raw_input()
			if ipMachine == "":
				ipMachine = ipDomain
			print("voici les ports ouverts et service actif de la machine : ")
			os.system("nmap -sV "+ipMachine+" -A -v")
			pass
	
def WPScan():
	url = ""
	print("Entrer l'url que vous voulez scanner (par defaut serveur IIS) : ")
	url = raw_input()
	if url == "":
		url = "http://"+ipDomain+":8082"
	os.system("wpscan --url "+url+" -e u,vp,vt,m --password-attack wp-login -P /usr/share/wordlists/dirb/common.txt")

def VulnScan():
	url = ""
	print("Entrer l'url que vous voulez scanner (par defaut serveur IIS) : ")
	url = raw_input()
	if url == "":
		url = ipDomain
	os.system("nikto -h "+url)	
	
def Main():
	title = "  _________                          .__  __                              .___     .__    ________ .__.__  \n "+"/   _____/ ____   ____  __ _________|__|/  |_ ___.__.   _____   ____   __| _/____ |  |   \_____  \|__|  |  \n"+" \_____  \_/ __ \_/ ___\|  |  \_  __ \  \   __<   |  |  /     \ /  _ \ / __ |/ __ \|  |     _(__  <|  |  |  \n"+" /        \  ___/\  \___|  |  /|  | \/  ||  |  \___  | |  Y Y  (  <_> ) /_/ \  ___/|  |__  /       \  |  |__\n"+"/_______  /\___  >\___  >____/ |__|  |__||__|  / ____| |__|_|  /\____/\____ |\___  >____/ /______  /__|____/\n"+"	\/     \/     \/                       \/            \/            \/    \/              \/      \n"  
	print(title)

	choix = -1

	while choix != 0 :
		print("*1* Injection SQL")
		print("*2* Injection JS")
		print("*3* Brute Force IIS")
		print("*4* File upload")
		print("*5* Directory exploration")
		print("*6* CrackPassword")
		print("*7* Scan reseau")
		print("*8* Scan Wordpress website")
		print("*9* Scan website vulnerabilities")
		print("*0* Quitter")	
		print("Veuillez taper le numero de l\'attaque a executer : ")
		choix = input()
		if int(choix) == 6:
			crackPassword()
		elif int(choix) == 7:
			scanReseau()
		elif int(choix) == 8:
			WPScan()
		elif int(choix) == 9:
			VulnScan()
		elif int(choix) == 5:
			webbrowser.open("http://172.16.217.117/directoryExploration/?enableSecurity=false&directory=.")
		elif int(choix) == 4:
			webbrowser.open("http://172.16.217.117/fileUpload/")
		elif int(choix) == 2:
			webbrowser.open("http://172.16.217.117/injectionJS/")
		elif int(choix) == 1:
			print("*1* Alter data integrity")
			print("*2* force Authentication")
			print("*0* retour")
			choix = input()
			if(choix == 1):
				webbrowser.open("http://172.16.217.117/injectionSQL/alterDataIntegrity/")
			elif(choix == 2):
				webbrowser.open("http://172.16.217.117/injectionSQL/forceAuthentification/")


Main()

