cd bin
dir /s /b c:\Core\*.php > ./list.txt
xgettext --keyword=t_ -f ./list.txt -o ./coreTemp.po
dir /s /b c:\Twinmusic\*.php >> ./list.txt
xgettext --keyword=t_ -f ./list.txt -o ./messagesTemp.po

;merger des fichiers de traductions
msgmerge.exe c:\Core\Twindoo\Languages\core.en.po ./coreTemp.po > ./core.en.po
msgmerge.exe ./core.en.po ./messagesTemp.po > ./temp.en.po
msgmerge.exe c:\Twinmusic\application\languages\lang.en.po ./temp.en.po > ./lang.en.po
msgfmt.exe -c ./message.en.po
msgfmt -o ./messages.en.mo ./message.en.po
