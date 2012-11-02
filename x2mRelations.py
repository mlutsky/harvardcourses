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

for course in soup.findAll('course'):
    if course['acad_year'] != '2012' and course.find('term')['spring_term'] != 'Y':
        print "not spring"
        continue

    catNum = course['cat_num']
    print catNum
    for courseGroup in course.findAll('course_group'):
        courseGroupName = courseGroup['code']
        c.execute("""SELECT id FROM `jharvard_project0`.`courses` WHERE catNum=%s""", (catNum))
        a = c.fetchone()[0]
        print a
        c.execute("""SELECT id FROM `jharvard_project0`.`courseGroups` WHERE name=%s""", (courseGroupName))
        b = c.fetchone()[0]
        print b
        c.execute("""INSERT INTO `jharvard_project0`.`courses_courseGroups` (`course_id`, `courseGroup_id`) VALUES (%s, %s);""", (a, b))

    for fac in course.find('faculty_list').findAll('faculty'):
        facLastName = fac.find('name').find('last').contents[0]
        c.execute("""SELECT id FROM `jharvard_project0`.`courses` WHERE catNum=%s""", (catNum))
        a = c.fetchone()[0]
        print a
        c.execute("""SELECT id FROM `jharvard_project0`.`faculty` WHERE lastName=%s""", (facLastName))
        b = c.fetchone()[0]
        print b
        c.execute("""INSERT INTO `jharvard_project0`.`courses_faculty` (`course_id`, `faculty_id`) VALUES (%s, %s);""", (a, b))



    gens = course.find('requirements').findAll(type='General Education')
    if gens:
        for gen in gens:
            gened = gen['name']
            c.execute("""SELECT id FROM `jharvard_project0`.`courses` WHERE catNum=%s""", (catNum))
            a = c.fetchone()[0]
            print a
            c.execute("""SELECT id FROM `jharvard_project0`.`geneds` WHERE name=%s""", (gened))
            b = c.fetchone()[0]
            print b
            c.execute("""INSERT INTO `jharvard_project0`.`courses_geneds` (`course_id`, `gened_id`) VALUES (%s, %s);""", (a, b))

    locs = course.find('meeting_locations').findAll('location')
    if locs:
        for loc in locs:
            locName = loc['building'] + ' ' + loc['room']
            c.execute("""SELECT id FROM `jharvard_project0`.`courses` WHERE catNum=%s""", (catNum))
            a = c.fetchone()[0]
            print a
            c.execute("""SELECT id FROM `jharvard_project0`.`locations` WHERE name=%s""", (locName))
            b = c.fetchone()[0]
            print b
            c.execute("""INSERT INTO `jharvard_project0`.`courses_locations` (`course_id`, `location_id`) VALUES (%s, %s);""", (a, b))

    scheds = course.find('schedule').findAll('meeting')
    if scheds:
        for sched in scheds:
            schedTuple = (sched['day'], sched['begin_time'] + "00", sched['end_time'] + "00")
            c.execute("""SELECT id FROM `jharvard_project0`.`courses` WHERE catNum=%s""", (catNum))
            a = c.fetchone()[0]
            print a
            c.execute("""SELECT id FROM `jharvard_project0`.`schedules` WHERE day=%s AND beginTime=%s AND endTime=%s""", schedTuple)
            b = c.fetchone()[0]
            print b
            c.execute("""INSERT INTO `jharvard_project0`.`courses_schedules` (`course_id`, `schedule_id`) VALUES (%s, %s);""", (a, b))

    db.commit()


db.close()

f.close()

