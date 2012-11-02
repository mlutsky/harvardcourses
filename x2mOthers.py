import MySQLdb
from BeautifulSoup import BeautifulStoneSoup

def noRepeats (arr, element):
    for e in arr:
        if e == element:
            return False
    return True

f = open("/home/jharvard/vhosts/project0/courses.xml", "r")
soup = BeautifulStoneSoup(f)

db = MySQLdb.connect(user="root", passwd="crimson", db="jharvard_project0")
c=db.cursor()

i = 0
courseGroups = []
faculty = []
geneds = []
locations = []
schedules = []

for course in soup.findAll('course'):
    if course['acad_year'] != '2012' and course.find('term')['spring_term'] != 'Y':
        print "not spring"
        continue

    print course['cat_num']
    for courseGroup in course.findAll('course_group'):
        courseGroupName = courseGroup['code']
        if noRepeats(courseGroups, courseGroupName):
            courseGroups.append(courseGroupName)
            c.execute("""INSERT INTO `jharvard_project0`.`courseGroups` (`id`, `name`) VALUES (NULL, %s);""", (courseGroupName))
    for fac in course.find('faculty_list').findAll('faculty'):
        facLastName = fac.find('name').find('last').contents[0]
        if noRepeats(faculty, facLastName):
            faculty.append(facLastName)
            c.execute("""INSERT INTO `jharvard_project0`.`faculty` (`id`, `lastName`) VALUES (NULL, %s);""", (facLastName))
    gens = course.find('requirements').findAll(type='General Education')
    if gens:
        for gen in gens:
            if noRepeats(geneds, gen['name']):
                geneds.append(gen['name'])
                c.execute("""INSERT INTO `jharvard_project0`.`geneds` (`id`, `name`) VALUES (NULL, %s);""", (gen['name']))

    locs = course.find('meeting_locations').findAll('location')
    if locs:
        for loc in locs:
            locName = loc['building'] + ' ' + loc['room']
            if noRepeats(locations, locName):
                locations.append(locName)
                c.execute("""INSERT INTO `jharvard_project0`.`locations` (`id`, `name`) VALUES (NULL, %s);""", (locName))

    scheds = course.find('schedule').findAll('meeting')
    if scheds:
        for sched in scheds:
            schedTuple = (sched['day'], sched['begin_time'] + "00", sched['end_time'] + "00")
            if noRepeats(schedules, schedTuple):
                schedules.append((sched['day'], sched['begin_time'], sched['end_time']))
                c.execute("""INSERT INTO `jharvard_project0`.`schedules` (`id`, `day`, `beginTime`, `endTime`) VALUES (NULL, %s, %s, %s);""", schedTuple)

    print faculty, geneds, locations, schedules


    db.commit()


db.close()

f.close()

