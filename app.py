#! C:\Users\Likith\AppData\Local\Programs\Python\Python38\python.exe

import sys
import numpy as np
import MySQLdb


print("Content-Type: text/html\n")

'''
db = MySQLdb.connect("localhost","root","","medicine" )

# prepare a cursor object using cursor() method
cursor = db.cursor()

# execute SQL query using execute() method.
cursor.execute("SELECT DISTINCT O_ID, M_ID FROM order_medicine WHERE O_ID UNIQUE")

# Fetch a single row using fetchone() method.
data = cursor.fetchall()
#print "Database version : %s " % data

# disconnect from server
db.close()
'''

# the given sequence
data =\
[
[4, 1.0],
[3, 2.0],
[1, 3.0],
[7, 2.0],
[6, 3.0]
]


X = np.matrix(data)[:,0]
y = np.matrix(data)[:,1]

def J(X, y, theta):
    theta = np.matrix(theta).T
    m = len(y)
    predictions = X * theta
    sqError = np.power((predictions-y),[2])
    return 1/(2*m) * sum(sqError)


dataX = np.matrix(data)[:,0:1]
X = np.ones((len(dataX),2))
X[:,1:] = dataX


# gradient descent function
def gradient(X, y, alpha, theta, iters):
    J_history = np.zeros(iters)
    m = len(y)
    theta = np.matrix(theta).T
    for i in range(iters):
        h0 = X * theta
        delta = (1 / m) * (X.T * h0 - X.T * y)
        theta = theta - alpha * delta
        J_history[i] = J(X, y, theta.T)
    return J_history, theta

#print('\n'+40*'=')

# theta initialization
theta = np.matrix([np.random.random(),np.random.random()])
alpha = 0.01 # learning rate
iters = 2000 # iterations

#print('\n== Model summary ==\nLearning rate: {}\nIterations: {}\nInitial theta: {}\nInitial J: {:.2f}\n'.format(alpha, iters, theta, J(X,y,theta).item()))

#print('Training the model... ')
# this actually trains our model and finds the optimal theta value
J_history, theta_min = gradient(X, y, alpha, theta, iters)
#print('Done.')
#print('\nThe modelled prediction function is:\ny = {:.2f} * x + {:.2f}'.format(theta_min[1].item(), theta_min[0].item()))
#print('Its cost equals {:.2f}'.format(J(X,y,theta_min.T).item()))


# This function will calculate the predicted profit
def predict(pop):
    return [1, pop] * theta_min

# Now
p = len(data)
#print('\n'+40*'=')
#print('The given sequence was:\n', *np.array(data)[:,1])
print('\nBased on learned data, next three predicted numbers in the sequence are {:,.1f}, {:,.1f}, {:,.1f}'.format(predict(p).item(), predict(p+1).item(), predict(p+2).item()))

#print('\nNOTE: The code uses linear regression model exclusively and tries to fit a "straight" line to the data. For polynominal it ought to be added theta_2 and beyond.')
