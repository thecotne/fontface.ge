import json
try:
	import sys
	import fontforge
	import os
	from pprint import pprint
	from inspect import getmembers
	if len(sys.argv) > 1:
		fonts = sys.argv[1:]
		converted = {}
		for fontfile in fonts:
			font = fontforge.open(fontfile)
			dr = 'public/webfonts/'+font.familyname+'/fonts'
			converted[fontfile] =font.familyname
			if not os.path.exists(dr):
				os.makedirs(dr)
			font.selection.all()
			font.autoHint()
			font.autoInstr()
			font.generate(dr+'/'+ font.familyname +'.ttf',flags=())
			font.close()
			del font
		print json.dumps({'status':1,'msg':'OK','converted':converted,'error':0})
	else:
		print json.dumps({'status':0,'msg':'No file given','error':2})
except Exception as e:
	print e
