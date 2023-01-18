#! /usr/bin/python

# usage message
import sys
if len(sys.argv) < 2:
    sys.exit("Usage: %s filename" % sys.argv[0])


filename = sys.argv[1]
import os
if not os.path.exists(filename):
    sys.exit("Error: File '%s' not found" % sys.argv[1])


class BaseCourt():
    def __init__(self, filename):
        self.filename = filename

    def __readFile(self):
        filetext = open(self.filename, 'r')
        return filetext

    def __getRecord(self):
        import re

        global players_dict
        players_dict = {}

        filetext = self.__readFile()
        for line in filetext:
            players = list(players_dict.keys())
            res = re.match(r"\b(\w+ \w+) batted (\d+) times with (\d+) hits and (\d+) runs\b", line)
            if res:
                name = res.group(1)
                times = int(res.group(2))
                hits = int(res.group(3))
                runs = int(res.group(4))
                if name not in players:
                    players_dict[name] = [times, hits]
                else:
                    players_dict[name][0] += times
                    players_dict[name][1] += hits
        return players_dict

    def __getGrade(self):
        players_dict = self.__getRecord()
        global grade_lst
        grade_lst = []
        for name, record in zip(players_dict.keys(), players_dict.values()):
            times = record[0]
            hits = record[1]
            grade = hits / times
            grade_lst.append([name, grade])

        sorted_garde_lst = sorted(grade_lst, key=lambda x: x[1], reverse=True)
        rounded_garde_lst = [[i[0], round(i[1], 3)] for i in sorted_garde_lst]
        return rounded_garde_lst

    def __call__(self, *args, **kwargs):
        print("*"*100)
        print("This is result form ", filename)
        final_lst = self.__getGrade()
        for line in final_lst:
            print('{}: {:.3f}'.format(line[0], line[1]))



base_cort = BaseCourt(filename)
base_cort()
