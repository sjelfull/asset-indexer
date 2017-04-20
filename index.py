from subprocess import call
import threading

def worker():
	"""thread worker function"""
	print call(["ls", "-l"])
	print 'Worker'

	return

def worker2(num):
    """thread worker function"""
    print 'Worker: %s' % num
    return

threads = []

for i in range(22):
	t = threading.Thread(target=worker)
	threads.append(t)
	t.start()

for i in range(200):
	t2 = threading.Thread(target=worker2, args=(i,))
	threads.append(t2)
	t2.start()
