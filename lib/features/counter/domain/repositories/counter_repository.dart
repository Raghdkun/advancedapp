import 'package:dartz/dartz.dart';
import '../../../../core/error/failures.dart';
import '../entities/counter.dart';

/// Counter repository interface
abstract class CounterRepository {
  Future<Either<Failure, Counter>> getCounter();
  Future<Either<Failure, Counter>> incrementCounter();
  Future<Either<Failure, Counter>> decrementCounter();
  Future<Either<Failure, void>> saveCounter(Counter counter);
  Future<Either<Failure, Counter>> resetCounter();
}
