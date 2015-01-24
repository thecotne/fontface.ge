import json
try:
	import sys
	import fontforge
	import os
	from pprint import pprint
	from inspect import getmembers
	# print os.getcwd()
	# print sys.argv

	if len(sys.argv) > 1:
		fonts = sys.argv[1:]
		converted = {}

		for fontfile in fonts:
			# pass
			# print fontfile

			font = fontforge.open(fontfile)

			dr = 'webfonts/'+font.familyname+'/fonts'

			converted[fontfile] =font.familyname

			if not os.path.exists(dr):
				os.makedirs(dr)
			font.selection.all()
			# pprint(getmembers(font))
			# for glyph in font.glyphs():
				# glyph

			font.autoHint()
			font.autoInstr()
			font.generate(dr+'/font.ttf',flags=())
			font.generate(dr+'/font.otf',flags=())
			font.generate(dr+'/font.eot',flags=())
			# print font.familyname
			# print "\n"
			font.close()
			del font
		print json.dumps({'status':1,'msg':'OK','converted':converted,'error':0})
	else:
		print json.dumps({'status':0,'msg':'No file given','error':2})

except Exception as e:
	print e
	# print json.dumps({'status':0,'msg': e,'error':1})

