#!/usr/local/bin/liquidsoap

set("log.stdout",true)
set("log.file",false)

set("harbor.icy",true)
set("harbor.bind_addr","0.0.0.0")
set("harbor.port",9002)

def auth(user,password) = 
  # Call an external process to check 
  # the credentials:
  # The script will return the string 
  # "true" or "false"
  #
  # First call the script
  ret = get_process_lines("./liquidsoap_automator.run #{password}")
  # Then get the first line of its output
  ret = list.hd(ret)
  # Finally return the boolean represented 
  # by the output
  if ret == "true" then
    true
  else
    false
  end
end

myLiveDJ = input.harbor(id='source',buffer=2.,max=2.,auth=auth,'/')
myAutoDJ = input.http('http://host:port/automation.ext')
mySource = fallback(track_sensitive=false,[myLiveDJ,myAutoDJ])
output.shoutcast.mp3(id='output',password='ChangeMe',port=9000,fallible=true,mksafe(mySource))
